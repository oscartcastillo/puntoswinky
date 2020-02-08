<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Exports\EncuestaExport;
use Carbon\Carbon;

use App\Empresa;
use App\TipoPerfil;
use App\Encuesta;
use App\Respuesta;

use Response;
use Validator;
use Excel;

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

        $fecha1 = $datos['fecha1']. " 00:00:00";
        $fecha2 = $datos['fecha2']. " 23:59:59";

        $perfil   = (empty($datos['perfil'])) ? 'T' : $datos['perfil'];
        $edad     = (empty($datos['edad'])) ? 'T' : $datos['edad'];
        $sucursal = (empty($datos['sucursal'])) ? 'T' : $datos['sucursal'];
        $horas    = (empty($datos['horas'])) ? 'T' : $datos['horas'];

        $respuesta  = Encuesta::join('respuestas', 'respuestas.user_id','=','encuestas.id')
            ->whereBetween('encuestas.created_at', [$fecha1, $fecha2])
            ->where(function($query) use ($perfil, $edad, $sucursal, $horas){
                    if($perfil == 'T'){
                        $query = $query->whereIn('encuestas.tipo_perfil_id', ['2','3','4','5','6']);
                    }
                    else{
                        $query = $query->where('encuestas.tipo_perfil_id', $perfil);
                    }

                    if($edad == 'T'){
                        $query = $query->whereIn('encuestas.edad', ['1','2','3']);
                    }
                    else{
                        $query = $query->where('encuestas.edad', $edad);
                    }

                    if($sucursal == 'T'){
                        $query = $query->where('encuestas.empresa_id', '!=', '');
                    }
                    else{
                        $query = $query->where('encuestas.empresa_id', $sucursal);
                    }

                    if($horas == 'T'){
                        $query = $query->whereIn('respuestas.respuesta7', ['A','B','C','D']);
                    }
                    else{
                        $query = $query->where('respuestas.respuesta7', $horas);
                    }
                })
            ->get();

        if(count($respuesta) < 1){

            $datos = array(
                'respuesta' => 'No hay datos'
            );
            return $datos;
        }

        $datos = [
            'respuesta1' => array( 'A' => 0,'B' => 0,'C' => 0,'D' => 0),
            'respuesta2' => array( 'A' => 0,'B' => 0,'C' => 0,'D' => 0),
            'respuesta3' => array( 'A' => 0,'B' => 0,'C' => 0,'D' => 0),
            'respuesta4' => array( 'A' => 0,'B' => 0,'C' => 0,'D' => 0),
            'respuesta5' => array( 'A' => 0,'B' => 0,'C' => 0,'D' => 0),
            'respuesta6' => array( 'A' => 0,'B' => 0,'C' => 0,'D' => 0),
            'respuesta7' => array( 'A' => 0,'B' => 0,'C' => 0,'D' => 0),
            'respuesta8' => array( 'A' => 0,'B' => 0,'C' => 0,'D' => 0),
            'respuesta9' => array( 'A' => 0,'B' => 0,'C' => 0,'D' => 0),
            'total' => count($respuesta)
        ];

        $platillos = [];

        foreach ($respuesta as $res)
        {
            for($i=0; $i < 10;  $i++){

                switch ($res['respuesta'.$i]) {
                    case 'A':
                        $datos['respuesta'.$i]['A'] = $datos['respuesta'.$i]['A'] + 1;
                    break;
                    case 'B':
                        $datos['respuesta'.$i]['B'] = $datos['respuesta'.$i]['B'] + 1;
                    break;
                    case 'C':
                        $datos['respuesta'.$i]['C'] = $datos['respuesta'.$i]['C'] + 1;
                    break;
                    case 'D':
                        $datos['respuesta'.$i]['D'] = $datos['respuesta'.$i]['D'] + 1;
                    break;
                }
            }
            array_push($platillos, $res['respuesta10']);
        }

        $datos['platillos'] = $platillos;

        return $datos;

    }

    public function export_table(Request $request){

        $datos = Input::all();
        $respuesta = $this->genera_reporte($datos);
        
        return Excel::download(new EncuestaExport($respuesta), 'Reporte Encuesta.xlsx');

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
