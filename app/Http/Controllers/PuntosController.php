<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TransaccionMail;
use Carbon\Carbon;

use Response;
use Validator;
use PDF;

use App\Perfil;
use App\User;
use App\Transaccion;
use App\Premio;
use App\Promocion;
use App\Participante;
use App\Empresa;


class PuntosController extends Controller
{
    
    protected $rules =
    [
        'transaccion_ticket' => 'required|unique:transacciones',
        'fecha' => 'required',
        'sucursal' => 'required',
        'monto'=> 'required|numeric|min:1|max:1000',
        'puntos' => 'nullable|required_with:descripcion|numeric|max:1000|min:1',
        'descripcion' => 'nullable|required_with:puntos'
    ];

    protected $rules_utilizar =
    [
        'transaccion_ticket' => 'required|unique:transacciones',
        'importe'=> 'required|numeric|min:1|max:1000'
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empresas = Empresa::all();
        return view('admin.puntos', compact('empresas'));
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

        $validator = Validator::make(Input::all(), $this->rules);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        else {

            $promo_a = $this->promocion_activa($request->fecha);
            $user = User::find($request->user_id);
            $porcen = $user->perfil->tipo_perfil->tipo_perfil_porcentaje / 100;

            $puntos_x = 'N/A';
            $descrip_x = 'N/A';
            $abono = $request->monto * $porcen;

            if ($request->puntos != '') {
                $puntos_x = $request->puntos;
                $descrip_x = $request->descripcion;
                $abono = ($request->monto * $porcen) + $request->puntos;
            }
            if ($promo_a == true && $promo_a['promocion_tipo'] == "puntos") {
                $abono = ($request->monto * $porcen) + $promo_a['promocion_cantidad'];
            }
            if ($promo_a == true && $promo_a['promocion_tipo'] == "porcentaje") {
                $abono = $request->monto * ($promo_a['promocion_cantidad'] / 100);
            }
            
            $transaccion = new Transaccion();
            $transaccion->transaccion_ticket = $request->transaccion_ticket;
            $transaccion->transaccion_fecha = $request->fecha;
            $transaccion->transaccion_cantidad = $request->monto;
            $transaccion->transaccion_puntos_extras = $puntos_x;
            $transaccion->transaccion_descripcion = $descrip_x;
            $transaccion->transaccion_abono = $abono;
            $transaccion->transaccion_tipo = 'Acumulados'; //acumular
            $transaccion->transaccion_estatus = 'Activo'; //acumular
            $transaccion->premio_id = NULL;
            $transaccion->promocion_id = $promo_a['id'];
            $transaccion->empresa_id = Auth::User()->perfil->empresa_id;
            $transaccion->vendedor_id = Auth::User()->id;
            $transaccion->user_id = $request->user_id;
            $transaccion->save();
            $transaccion['puntos'] = $this->get_puntos($request->user_id);
            /*if ($transaccion) {
                return $this->send_mail($request->user_id, $transaccion);
            }*/

            if( isset($request->imprimir) && $request->imprimir == 'si'){
                $transaccion['url'] = 'imprimir';
            }

            return response()->json($transaccion);
        }
    }

    public function promocion_activa($hoy){

        $promocion = Promocion::all();       
        setlocale(LC_TIME, 'spanish');
        $fecha_hoy = strftime("%A", strtotime($hoy));
        $utf_dia = utf8_encode($fecha_hoy);
        
        foreach ($promocion as $promo) {

            $inicio = $promo->promocion_inicio;
            $fin = $promo->promocion_fin;
            $dias = $promo->promocion_dias_nombre;
            $rango = $this->check_in_range($inicio, $fin, $hoy);
            $participa = $this->participa($promo->id);
            
            if ($rango == true && $participa == true && $promo->promocion_repetir == 'A') {
                return $promo;
            }
            elseif ($rango == true && $participa == true && $promo->promocion_repetir == 'D') {
                $dias_explode = explode(",", $dias);
                if (in_array($utf_dia, $dias_explode)) {   
                    return $promo;
                }
            }
        }
    }

    public function check_in_range($fecha_inicio, $fecha_fin, $fecha){

        if ($fecha_fin == '') {
            $fecha_fin = $fecha_inicio;
        }
        
        $fecha_inicio = strtotime($fecha_inicio);
        $fecha_fin = strtotime($fecha_fin);
        $fecha = strtotime($fecha);

        if(($fecha >= $fecha_inicio) && ($fecha <= $fecha_fin))
            return true;
        else
            return false;
    }

    public function participa($promo){
        
        $participantes = array_merge(
            Participante::where('promocion_id', $promo)->pluck('empresa_id')->toArray()
        );
        
        $id_empresa = Auth::User()->perfil->empresa_id;
        
        if (in_array( $id_empresa , $participantes))
            return true;
        else
            return false;
    }

    public function utilizar(Request $request)
    {
        $dt = Carbon::now();
        $hoy = $dt->toDateString(); 
        
        $datos_input = [
            'transaccion_ticket' => $hoy."/".Auth::User()->perfil->empresa_id."/".$request->transaccion_ticket,
            'importe' => $request->importe
        ];

        $validator = Validator::make($datos_input, $this->rules_utilizar);
        $aprobacion = $this->valida_utiliza($request->user_id, $request->importe);
        
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        
        if ($aprobacion['estatus'] == 'negado'){
            return response()->json($aprobacion);
        }

        $transaccion = new Transaccion();
        $transaccion->transaccion_ticket = $datos_input['transaccion_ticket'];
        $transaccion->transaccion_fecha = date('Y-m-d');
        $transaccion->transaccion_cantidad = $request->importe;
        $transaccion->transaccion_puntos_extras = 'N/A';
        $transaccion->transaccion_descripcion = 'N/A';
        $transaccion->transaccion_abono = $request->importe * -1;
        $transaccion->transaccion_tipo = 'Utilizados';
        $transaccion->transaccion_estatus = 'Activo'; //acumular
        $transaccion->premio_id = NULL;
        $transaccion->promocion_id = NULL;
        $transaccion->empresa_id = Auth::User()->perfil->empresa_id;
        $transaccion->vendedor_id = Auth::User()->id;
        $transaccion->user_id = $request->user_id;

        if ($aprobacion['estatus'] == 'aprobado') {
            $transaccion->save();
            $transaccion['puntos'] =  $this->get_puntos($request->user_id);

            /*if ($transaccion) {
                return $this->send_mail($request->user_id, $transaccion);
            }*/
            return response()->json($transaccion);
        }
        
        //return response()->json($transaccion);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
    public function destroy(Request $request, $id)
    {

        $validator = Validator::make(Input::all(),['motivo' => 'required']);
        
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        else{
            
            $transaccion = Transaccion::findOrFail($id);
            $puntos = $this->get_puntos($transaccion->perfil->user_id);
            $total = $puntos - $transaccion->transaccion_abono;

            if($total < 0){
                
                $result = [
                    'errors' => array(
                        'negacion' => 'No se puede cancelar, ya estan utilizados los puntos que quiere cancelar'
                    )
                ];

                return response()->json($result);
            }

            if ($transaccion->transaccion_tipo == 'Por Premio') {
                $premio =  Premio::findOrFail($transaccion->premio_id);
                $premio->premio_stock = $premio->premio_stock + 1;
                $premio->push();
            }
            $transaccion->transaccion_tipo = "Cancelacion";
            $transaccion->cancelacion_id = Auth::User()->id;
            $transaccion->cancelacion_descripcion = $request->motivo;
            $transaccion->push();
        }
    }


    public function getcliente(Request $request){

        $dato = $request->dato;

        $data = User::select('perfiles.perfil_nombre', 'perfiles.perfil_apellidos', 'perfiles.perfil_tarjeta', 'perfiles.perfil_celular', 'users.email', 'users.id')
            ->join('perfiles', 'users.id','=','perfiles.user_id')
            ->where([
                [
                    function($query) use ($dato){
                        $query->where('perfiles.perfil_nombre', 'LIKE', '%'.$dato.'%');
                        $query->orWhere('perfiles.perfil_apellidos', 'LIKE', '%'.$dato.'%');
                        $query->orWhere('perfiles.perfil_tarjeta', 'LIKE', '%'.$dato.'%');
                        $query->orWhere('perfiles.perfil_celular', 'LIKE', '%'.$dato.'%');
                        $query->orWhere('users.email', 'LIKE', '%'.$dato.'%');
                    }
                ],
                ['perfiles.clasificacion_id', '!=', null],
                ['users.estatus', '=', 'A']
            ])
            ->take(5)
            ->get();

        //return $data;

        $output = '<div id="div-result" class="dropdown-menu bs-component" style="display:block; position:absolete; min-width: 16rem;"><div class="list-group">';

        if (count($data) > 0) {
            foreach($data as $row){

                if (strlen($row->perfil_tarjeta) > 10) {
                    $tarjeta = '';
                }
                else{
                    $tarjeta = $row->perfil_tarjeta; 
                }

                $output .= '<a class="list-group-item list-group-item-action" href="#"><h5 class="list-group-item-heading">'. $row->perfil_nombre . " " . $row->perfil_apellidos. '</h5><p class="list-group-item-text"><strong>|Tarjeta: </strong>'. $tarjeta .'</p><p class="list-group-item-text"><strong>|Telefono: </strong>'. $row->perfil_celular.'</p><p class="list-group-item-text"><strong>|Correo: </strong>'. $row->email.'</p><input type="hidden" id="id" value='.$row->id.'></a>';
            }
        }
        else{
            $output .= '<a class="list-group-item list-group-item-action" href="#"><h5 class="list-group-item-heading">No hay resultados...</h5></a>';
        }
        
        $output .= '</div></div>';
        echo $output;
    }
    public function getDatos(Request $request, $id){

        $user = User::find($id);
        $puntos = $this->get_puntos($id);
        $transacciones = Transaccion::where([
                ['user_id', '=', $id],
                ['transaccion_estatus', 'Activo']
            ])
            ->orderBy('created_at', 'desc')
            ->get();
        
        $premios = Premio::where([
            ['clasificacion_id', '=', $user->perfil->clasificacion_id],
            ['empresa_id', '=', Auth::User()->perfil->empresa_id],
            ['premio_stock', '>', 0],
        ])->get();

        $general = [
            'user' => $user,
            'puntos' =>$puntos,
            'transacciones' => $transacciones,
            'premios' => $premios
        ];

        return response()->json($general);
        
    }

    public function get_puntos($id){

        $puntos = User::join('transacciones', 'users.id' , '=', 'transacciones.user_id')
            ->where([
                ['transacciones.user_id', '=', $id],
                ['transacciones.transaccion_tipo', '!=', 'Cancelacion'],
                ['transacciones.transaccion_estatus', 'Activo']
            ])
            ->sum('transacciones.transaccion_abono');

        return number_format($puntos,2);
    }

    public function cambiar_premio(Request $request, $id){

        $aprobacion = $this->valida_transaccion($request->user_id, $id);

        if ($aprobacion['estatus'] == 'aprobado') {
            
            $transaccion = Transaccion::all()->last();
            $id_next = $transaccion->id;
            $ticket_new = "P". str_pad($id_next, 9, '0', STR_PAD_LEFT);
            
            $transaccion = new Transaccion();
            $transaccion->transaccion_ticket = $ticket_new;
            $transaccion->transaccion_fecha = date('Y-m-d');
            $transaccion->transaccion_cantidad = $aprobacion['premio']['premio_precio'];
            $transaccion->transaccion_puntos_extras = 'N/A';
            $transaccion->transaccion_descripcion = 'N/A';
            $transaccion->transaccion_abono = $aprobacion['premio']['premio_precio'] * -1;
            $transaccion->transaccion_tipo = 'Por Premio';
            $transaccion->transaccion_estatus = 'Activo'; //acumular
            $transaccion->premio_id = $id;
            $transaccion->promocion_id = NULL;
            $transaccion->empresa_id = Auth::User()->perfil->empresa_id;
            $transaccion->vendedor_id = Auth::User()->id;
            $transaccion->user_id = $request->user_id;
            $transaccion->save();

            $transaccion['puntos'] = $this->get_puntos($request->user_id);
            $transaccion['premio'] = $aprobacion['premio'];

            /*if ($transaccion) {
                return $this->send_mail($request->user_id, $transaccion);
            }*/

            return response()->json($transaccion);
        }
        return response()->json($aprobacion);
        
    }

    public function listado_puntos(){
        $transacciones = Transaccion::whereDate('created_at', Carbon::today())->get();
        return view('admin.listado_puntos', compact('transacciones'));
    }

    public function export_pdf($id, $tipo){

        if ($tipo == 'general') {
            $user = User::find($id);
            $puntos = User::join('transacciones', 'users.id' , '=', 'transacciones.user_id')
            ->where([
                ['transacciones.user_id', '=', $user->id],
                ['transacciones.transaccion_tipo', '!=', 'Cancelacion'],
            ])
            ->sum('transacciones.transaccion_abono');
            
            $transacciones =  Transaccion::where('user_id', $user->id)->get();
        
        }
        elseif ($tipo == 'especifico') {

            $transacciones = Transaccion::find($id);

            $puntos = User::join('transacciones', 'users.id' , '=', 'transacciones.user_id')
            ->where([
                ['transacciones.user_id', '=', $transacciones->user_id],
                ['transacciones.transaccion_tipo', '!=', 'Cancelacion'],
            ])
            ->sum('transacciones.transaccion_abono');

            $user = User::find($transacciones->user_id);
        }
        
        $pdf = PDF::loadView('admin.plantillas_export.estado_cuenta', compact('transacciones', 'user', 'puntos', 'tipo'));
        
        return $pdf->download($user->perfil->perfil_nombre." ".$user->perfil->perfil_apellidos.'.pdf');

    }

    public function valida_transaccion($user_id, $id){

        $puntos = $this->get_puntos($user_id);
        $premio = Premio::findOrFail($id);

        if ($puntos >= $premio->premio_precio) {
            
            $premio->premio_stock  = $premio->premio_stock - 1;
            $premio->push();
            
            $aprobacion = [
                'estatus' => 'aprobado',
                'premio' => $premio
            ];
        }
        else{
            $aprobacion = [
                'estatus' => 'negado',
                'mensaje' => 'puntos insuficientes' 
            ];
        }
        return $aprobacion;

    }

    public function valida_utiliza($user_id, $importe){

        $puntos = User::join('transacciones', 'users.id' , '=', 'transacciones.user_id')
            ->where([
                ['transacciones.user_id', '=', $user_id],
                ['transacciones.transaccion_tipo', '!=', 'Cancelacion'],
            ])
            ->sum('transacciones.transaccion_abono');

        if ($puntos >= $importe) {
            
            $aprobacion = [
                'estatus' => 'aprobado',
                'puntos' => $puntos - $importe,
            ];
        }
        else{
            $aprobacion = [
                'estatus' => 'negado',
                'mensaje' => 'puntos insuficientes' 
            ];
        }
        return $aprobacion;
    }

    public function send_mail($id, $transaccion){

        $user = User::findOrFail($id);
        Mail::to('murdokcas@gmail.com')->send(new TransaccionMail($user, $transaccion));
    }

    public function imprime($id)
    {
        $transaccion = Transaccion::findOrFail($id);
        
        $pdf = PDF::loadView('admin.plantillas_export.transacciones', compact('transaccion'));
        return $pdf->download('transaccion.pdf');
    }
}