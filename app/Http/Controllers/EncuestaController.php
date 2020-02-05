<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Empresa;
use App\TipoPerfil;
use App\Encuesta;
use App\Respuesta;

use Response;
use Validator;

class EncuestaController extends Controller
{

    protected $rules1 =
    [
        'nombre' => 'required',
        'email' => 'required|email|unique:encuestas',
        'sexo' => 'required',
        'edad' => 'required',
        'tipo' => 'required',
        'sucursal' => 'required',
        'difusion' => 'required',
    ];

    protected $rules2 =
    [
        'pregunta_1' => 'required',
        'pregunta_2' => 'required',
        'pregunta_3' => 'required',
        'pregunta_4' => 'required',
        'pregunta_5' => 'required',
        'pregunta_6' => 'required'
    ];

    protected $rules3 =
    [
        'pregunta_7' => 'required',
        'pregunta_8' => 'required',
        'pregunta_9' => 'required',
        'pregunta_10' => 'required'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check()){
            
            $tipo_perfiles = TipoPerfil::where('tipo_perfil_nombre', '!=', 'Personal')->get();
            $empresas = Empresa::all();
            return view('admin.encuesta_reporte', compact('tipo_perfiles', 'empresas'));
        }
        
        $perfiles = TipoPerfil::where('tipo_perfil_nombre', '!=', 'Personal')->get();
        $empresas = Empresa::all();
        return view('inicio.encuesta', compact('perfiles', 'empresas'));
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
        $datos = Input::all();
        
        if(Auth::check() && $request->operation == 'Auth'){
            $respuesta = $this->genera_reporte($datos);
            return response()->json($respuesta);
        }
        
        switch ($request->operation) {
            case 1:
                $validator = Validator::make($datos, $this->rules1);
                if ($validator->fails()) {
                    return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
                }
            break;
            case 2:
                $validator = Validator::make($datos, $this->rules2);
                if ($validator->fails()) {
                    return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
                }
            break;
            case 3:
                $validator = Validator::make($datos, $this->rules3);
                if ($validator->fails()) {
                    return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
                }
            break;
        }
        if(!isset($request->operation)){
            $respuesta = $this->guarda_informacion($datos);
            return response()->json($respuesta);
        }    
    }

    public function genera_reporte($datos)
    {
        $fecha1 = $datos['fecha1'];
        $fecha2 = $datos['fecha2'];
        
        $perfil = ($datos['perfil'] != '') ? $datos['perfil'] : ['2','3','4','5','6'];
        $edad = $datos['edad'];
        $sucursal = $datos['sucursal'];
        $horas = $datos['horas'];
        
        $respuesta  = Encuesta::join('respuestas', 'respuestas.user_id','=','encuestas.id')
            ->whereBetween($fecha1, $fecha2)
            ->whereIn([
                ['encuestas.tipo_perfil_id', $perfil]
            ]
                
            }
                
            )
            ->get();
        
        return $encuestas;

    }

    public function guarda_informacion($datos)
    {
        
        $encuestas = new Encuesta();
        $encuestas->nombre = $datos['nombre'];
        $encuestas->email = $datos['correo'];
        $encuestas->edad = $datos['edad'];
        $encuestas->sexo = $datos['sexo'];
        $encuestas->medio_difucion = $datos['difusion'];
        $encuestas->tipo_perfil_id = $datos['tipo'];
        $encuestas->empresa_id = $datos['sucursal'];
        $encuestas->save();

        $respuestas = new Respuesta();
        $respuestas->respuesta1 = $datos['pregunta_1'];
        $respuestas->respuesta2 = $datos['pregunta_2'];
        $respuestas->respuesta3 = $datos['pregunta_3'];
        $respuestas->respuesta4 = $datos['pregunta_4'];
        $respuestas->respuesta5 = $datos['pregunta_5'];
        $respuestas->respuesta6 = $datos['pregunta_6'];
        $respuestas->respuesta7 = $datos['pregunta_7'];
        $respuestas->respuesta8 = $datos['pregunta_8'];
        $respuestas->respuesta9 = $datos['pregunta_9'];
        $respuestas->respuesta10 = $datos['pregunta_10'];
        $respuestas->user_id = $encuestas->id;
        $respuestas->save();

        return response()->json($encuestas);
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
}
