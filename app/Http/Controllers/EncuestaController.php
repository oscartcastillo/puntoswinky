<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Empresa;
use App\TipoPerfil;
use App\Encuesta;

use Response;
use Validator;

class EncuestaController extends Controller
{

    protected $rules1 =
    [
        'nombre' => 'required',
        'correo' => 'required',
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

    public function guarda_informacion($datos)
    {
        
        $encuestas = new Encuesta();
        $encuestas->nombre = $request->nombre;
        $encuestas->email = $request->correo;
        $encuestas->edad = $request->edad;
        $encuestas->sexo = $request->sexo;
        $encuestas->medio_difucion = $request->difusion;
        $encuestas->tipo_perfil_id = $request->tipo;
        $encuestas->empresa_id = $request->sucursal;
        $encuestas->save();
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