<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaccion;
use App\User;
use App\Perfil;
use App\TipoPerfil;
use App\Empresa;
use Carbon\Carbon;
use DB;

class ReportesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = User::where('name','=', 'cliente')->count();

        //consulta clientes con tarjeta
        $clientes_t = User::join('perfiles', 'users.id', '=', 'perfiles.user_id')
        ->where('users.name','=','cliente')
        ->whereRaw('LENGTH(perfiles.perfil_tarjeta) <= 10')
        ->count();
        
        //clientes registrados en el dia
        $clientes_dia = User::where('name', '=', 'cliente')
        ->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))
        ->count();

        //clientes registrados por semana
        $clientes_semana = User::where('name', '=', 'cliente')
        ->whereBetween('created_at', [Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])
        ->count();
        
        //clientes registrador por mes
        $clientes_mes = User::where('name', '=', 'cliente')
        ->whereMonth('created_at', Carbon::now()->format('m'))
        ->whereYear('created_at', Carbon::now()->format('Y'))
        ->count();
        
        //clientes sin tarjeta
        $clientes_sin_tarjeta = User::join('perfiles', 'users.id', '=', 'perfiles.user_id')
        ->where([
            ['users.name', '=', 'cliente']
        ])
        ->whereRaw('LENGTH(perfiles.perfil_tarjeta) > 10')
        ->count();
               
        $puntos_acumulados_mes = Transaccion::where('transaccion_tipo','=','Acumulados')
            ->whereMonth('created_at', Carbon::now()->format('m'))
            ->whereYear('created_at', Carbon::now()->format('Y'))
            ->sum('transacciones.transaccion_abono');

        $puntos_acumulados = Transaccion::where('transaccion_tipo','!=','Cancelacion')
            ->sum('transacciones.transaccion_abono');

        $puntos_utilizados_mes = Transaccion::where('transaccion_tipo','=','Utilizados')
            ->whereMonth('created_at', Carbon::now()->format('m'))
            ->whereYear('created_at', Carbon::now()->format('Y'))
            ->sum('transacciones.transaccion_abono');

        $premios_otorgados_mes = Transaccion::where('transaccion_tipo','=','Por premio')
            ->whereMonth('created_at', Carbon::now()->format('m'))
            ->whereYear('created_at', Carbon::now()->format('Y'))
            ->count();

        $cancelaciones_mes = Transaccion::where('transaccion_tipo','=','Cancelacion')
            ->whereMonth('created_at', Carbon::now()->format('m'))
            ->whereYear('created_at', Carbon::now()->format('Y'))
            ->count();

        //puntos a utilizar
        $puntos_utilizar = Transaccion::where('transaccion_tipo', '!=', 'Cancelacion')
            ->sum('transaccion_abono');

        $deshabilitados = User::where('estatus', '!=', 'A')->count();

        //empleados
        $empleados = User::whereHas(
            'roles', function($emp){
                $emp->where('name', '!=', 'cliente');
            }
        )->get();

        $data = array(
            'clientes_totales' => $clientes_t,
            'clientes_dia' => $clientes_dia,
            'clientes_semana' => $clientes_semana,
            'clientes_mes' => $clientes_mes,
            'clientes_sin_tarjeta' => $clientes_sin_tarjeta,
            'puntos_utilizados_mes' => $puntos_utilizados_mes,
            'puntos_utilizar' => $puntos_utilizar,
            'clientes_deshabilitados' => $deshabilitados,
            'puntos_acumulados' => $puntos_acumulados,
            'empleados' => $empleados
        );
            
        return view('admin.reportes', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function genera_reporte(Request $request){

        $tipo = $request->data['tipo'];
        
        switch ($tipo) {
            case '1': //clientes por categoria

                $tbody = Perfil::select(
                    'perfiles.perfil_nombre',
                    'perfiles.perfil_apellidos',
                    'tipo_perfiles.tipo_perfil_nombre',
                    DB::raw('(CASE WHEN LENGTH(perfiles.perfil_tarjeta) > 10 then "" ELSE "NoTarjeta" END) AS tarjeta'),
                    DB::raw('SUM(transacciones.transaccion_abono) as puntos'))
                    ->leftJoin('transacciones', 'transacciones.user_id', '=', 'perfiles.user_id')
                    ->Join('tipo_perfiles', 'tipo_perfiles.id', '=', 'perfiles.tipo_perfil_id')
                    ->where('perfiles.tipo_perfil_id', $request->data['categoria'])
                    ->groupBy(
                        'perfiles.perfil_nombre',
                        'perfiles.perfil_apellidos',
                        'tipo_perfiles.tipo_perfil_nombre',
                        'perfiles.perfil_tarjeta',
                    )
                    ->get();

                $thead = ['Nombre', 'Apellidos', 'Categoria','Tarjeta','Puntos Disponibles'];
                $data = [
                    'thead' => $thead,
                    'tbody' => $tbody
                ];
                
                return Response()->json($data);
                
                break;

            case '2'://clientes por clasificacion
                $tbody = Perfil::select(
                    'perfiles.perfil_nombre',
                    'perfiles.perfil_apellidos',
                    'clasificaciones.clasificacion_nombre',
                    DB::raw('(CASE WHEN LENGTH(perfiles.perfil_tarjeta) > 10 then "" ELSE "NoTarjeta" END) AS tarjeta'))
                    ->Join('clasificaciones', 'clasificaciones.id', '=', 'perfiles.clasificacion_id')
                    ->where('perfiles.clasificacion_id', $request->data['clasificacion'])
                    ->groupBy(
                        'perfiles.perfil_nombre',
                        'perfiles.perfil_apellidos',
                        'clasificaciones.clasificacion_nombre',
                        'perfiles.perfil_tarjeta',
                    )
                    ->get();

                $thead = ['Nombre', 'Apellidos', 'Categoria','Tarjeta'];
                $data = [
                    'thead' => $thead,
                    'tbody' => $tbody
                ];
                
                return Response()->json($data);
                break;

            case '3':// clientes sin tarjeta

                $tbody = User::select(
                    'perfiles.perfil_nombre',
                    'perfiles.perfil_apellidos',
                    'users.email')
                    ->join('perfiles', 'users.id', '=', 'perfiles.user_id')
                    ->where('users.name','=','cliente')
                    ->whereRaw('LENGTH(perfiles.perfil_tarjeta) >= 10')
                    ->get();

                $thead = ['Nombre', 'Apellidos','Correo'];
                
                $data = [
                    'thead' => $thead,
                    'tbody' => $tbody
                ];
                return Response()->json($data);

                break;

            case '4':// transacciones por dia

                $tbody = Transaccion::select(
                        'perfiles.perfil_nombre',
                        'perfiles.perfil_apellidos',
                        DB::raw('(CASE WHEN LENGTH(perfiles.perfil_tarjeta) > 10 then "" ELSE "NoTarjeta" END) AS tarjeta'),
                        'transacciones.transaccion_ticket',
                        'transacciones.transaccion_fecha',
                        'transacciones.transaccion_tipo',
                        'transacciones.transaccion_abono'
                    )
                    ->leftJoin('perfiles', 'perfiles.user_id', '=', 'transacciones.user_id')
                    ->where('perfiles.vendedor_id', $request->data['personal'])
                    ->whereBetween('transacciones.created_at', [$request->data['inicio'].' 00:00:00', $request->data['fin'].' 23:59:59'])
                    ->groupBy(
                        'perfiles.perfil_nombre',
                        'perfiles.perfil_apellidos',
                        'perfiles.perfil_tarjeta',
                        'transacciones.transaccion_ticket',
                        'transacciones.transaccion_fecha',
                        'transacciones.transaccion_tipo',
                        'transacciones.transaccion_abono'
                    )
                    ->get();

                $thead = ['Nombre', 'Apellidos', 'Tarjeta', 'Ticket', 'Fecha de Registro', 'Tipo', 'Abono'];
                
                $data = [
                    'thead' => $thead,
                    'tbody' => $tbody
                ];
                return Response()->json($data);
                
                break;

            case '5'://registro por vendedor

                $tbody = Perfil::select(
                        DB::raw('(CASE WHEN LENGTH(perfiles.perfil_tarjeta) > 10 then "" ELSE "NoTarjeta" END) AS tarjeta'),
                        'perfiles.perfil_nombre',
                        'perfiles.perfil_apellidos',
                        'perfiles.created_at',
                        DB::raw('SUM(transacciones.transaccion_abono) as puntos')
                    )
                    ->leftJoin('transacciones', 'transacciones.user_id', '=', 'perfiles.user_id')
                    ->where('perfiles.vendedor_id', $request->data['personal'])
                    ->whereBetween('perfiles.created_at', [$request->data['inicio'], $request->data['fin']])
                    ->groupBy(
                        'perfiles.perfil_nombre',
                        'perfiles.perfil_apellidos',
                        'perfiles.created_at',
                        'perfiles.perfil_tarjeta'
                    )
                    ->get();

                $thead = ['Tarjeta','Nombre','Apellidos','Fecha de Registro','Puntos'];
                $data = [
                    'thead' => $thead,
                    'tbody' => $tbody
                ];
                return Response()->json($data);
                
                break;

            case '6'://ventas
                $tbody = Perfil::select(
                        'perfiles.perfil_nombre',
                        'perfiles.perfil_apellidos',
                        DB::raw('(CASE WHEN LENGTH(perfiles.perfil_tarjeta) > 10 then "" ELSE "NoTarjeta" END) AS tarjeta'),
                        DB::raw('SUM(transacciones.transaccion_cantidad) as ventas')
                    )
                    ->leftJoin('transacciones', 'transacciones.user_id', '=', 'perfiles.user_id')
                    ->whereBetween('perfiles.created_at', [$request->data['inicio'], $request->data['fin']])
                    ->groupBy(
                        'perfiles.perfil_nombre',
                        'perfiles.perfil_apellidos',
                        'perfiles.created_at',
                        'perfiles.perfil_tarjeta'
                    )
                    ->get();

                $thead = ['Nombre','Apellidos','Tarjeta','Ventas'];
                $data = [
                    'thead' => $thead,
                    'tbody' => $tbody
                ];
                return Response()->json($data);
                break;
            
            default:
                break;
        }
    }

    public function encuesta(Request $request)
    {
        $tipo_perfiles = TipoPerfil::where('tipo_perfil_nombre', '!=', 'Personal')->get();
        $empresas = Empresa::all();
        return view('admin.encuesta', compact('tipo_perfiles', 'empresas'));
    }

    public function respuesta_encuesta(Request $request)
    {

    }
}
