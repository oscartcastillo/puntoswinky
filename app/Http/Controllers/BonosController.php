<?php

namespace App\Http\Controllers;


use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Perfil;
use App\User;
use App\Bono;
use App\BonoDetalle;

use Response;
use Validator;

class BonosController extends Controller
{

    protected $rules =
    [
        'tipo' => 'required',
        'inicio'=> 'required|date',
        'fin' => 'required|date'
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.bonos');  
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

        $this->create_tiempos($request->user_id);

        $bono_detalle = BonoDetalle::where([
            ['user_id','=', $request->user_id],
            ['tiempo_id','=', $request->tiempo_id]
        ])
        ->whereDate('created_at', '=', Carbon::today()->toDateString())
        ->first();
        
        $bono_detalle->detalle_bono_estatus = 'entregado';
        $bono_detalle->empresa_id = Auth::User()->perfil->empresa_id;
        $bono_detalle->vendedor_id = Auth::User()->id;
        $bono_detalle->push();
        $bono_detalle['empresa_nombre'] = Auth::User()->perfil->empresa->empresa_nombre;

        return Response()->json($bono_detalle);
    }

    private function create_tiempos($user_id){

        $bono_id = Bono::active()
                        ->orderBy('created_at', 'desc')
                        ->where('user_id', $user_id)
                        ->first();

        $bono_consulta = BonoDetalle::where('user_id', '=', $user_id)
        ->whereDate('created_at', '=', Carbon::today()->toDateString())
        ->count();

        $timestamp = Carbon::now();

        if ($bono_consulta == 0 ) {
            
            $data = array(
                array(
                    'tiempo_id'  => 1,
                    'user_id' => $user_id,
                    'bono_id' => $bono_id['id'],
                    'detalle_bono_estatus' => 'pendiente',
                    'created_at' => $timestamp,
                ),
                array(
                    'tiempo_id' => 2,
                    'user_id' => $user_id,
                    'bono_id' => $bono_id['id'],
                    'detalle_bono_estatus' => 'pendiente',
                    'created_at' => $timestamp,
                ),
                array(
                    'tiempo_id' => 3,
                    'user_id' => $user_id,
                    'bono_id' => $bono_id['id'],
                    'detalle_bono_estatus' => 'pendiente',
                    'created_at' => $timestamp,
                )
            );

            BonoDetalle::insert($data);
        }
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

    public function getDatos(Request $request, $id){

        $user = User::with('perfil')->find($id);
        $bonos = Bono::with('tipo_bono')
                        ->where([
                            ['user_id', '=', $id],
                            ['bono_inicio', '<=', Carbon::today()->toDateString() ],
                            ['bono_fin', '>=', Carbon::today()->toDateString() ]
                        ])
                        ->orderBy('created_at', 'desc')
                        ->active()
                        ->first();

        $bonos_vencidos = Bono::with('tipo_bono')
                        ->where([
                            ['user_id', '=', $id],
                            ['bono_estatus', '=', 'vencido']
                        ])
                        ->orderBy('created_at', 'desc')
                        ->first();

        $detalle_bonos = BonoDetalle::with('empresa')->where('user_id', $id)->get();

        $general = [
            'user' => $user,
            'bonos' => $bonos,
            'bonos_vencidos' => $bonos_vencidos,
            'detalle_bono' => $detalle_bonos
        ];

        return response()->json($general);
    }

    public function generaBono(Request $request){

        $validator = Validator::make(Input::all(), $this->rules);
        
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        else{

            $inicio = date('Y-m-d', strtotime($request->inicio));
            $fin = date('Y-m-d', strtotime($request->fin));

            $bono = new Bono();
            $bono->bono_inicio = $inicio;
            $bono->bono_fin = $fin;
            $bono->tipo_bono_id = $request->tipo;
            $bono->user_id = $request->user_id;
            $bono->vendedor_id = Auth::User()->id;
            $bono->empresa_id = Auth::User()->perfil->empresa_id;
            $bono->bono_estatus = 'activo';
            $bono->save();

            return response()->json($bono);
        }

    }
}