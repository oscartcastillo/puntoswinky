<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Response;
use Validator;

use File;
use App\Empresa;
use App\Ciudad;
use App\Clasificacion;

class ConfigController extends Controller
{
    protected $rules_empresa =
    [
        'empresa_nombre' => 'required|min:3|max:90',
        'empresa_ubicacion' => 'required|min:3|max:90',
        'empresa_cp' => 'required|numeric',
        'empresa_numero' => 'required|numeric',
        'empresa_ciudad' => 'required'
    ];

    protected $rules_ciudad =
    [
        'ciudad_nombre' => 'required|min:3|max:90',
    ];

    protected $rules_config =
    [
        'vigencia' => 'required|numeric',
        'puntos_iniciales' => 'required|numeric',
        'reset_clasificacion' => 'required|numeric'
    ];

    protected $rules_clasificacion =
    [
        'clasificacion_min' => 'required|numeric',
        'clasificacion_max' => 'required|numeric'
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empresas = Empresa::all();
        $ciudades = Ciudad::all();
        $clasificaciones = Clasificacion::all();

        $data = File::get("json/config.json");
        $json = json_decode($data, true);
        $vigencia = $json['vigencia'];
        $puntos_iniciales = $json['bono_inicio'];
        $reset_clasificacion = $json['tiempo_clasificacion'];
        
        return view('admin.config', compact('ciudades', 'empresas', 'vigencia', 'puntos_iniciales', 'clasificaciones', 'reset_clasificacion'));
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
        $params = Input::all();
        $type = $request->nameConfig;

        switch ($type) {
            case 1:
                $response = $this->crea_empresa($params);
            break;
           
            case 2:
                $response = $this->crea_ciudad($params);
            break;
            
            case 3:
                $response = $this->config_general($params);
            break;

            case 4:
                $response = $this->clasificaciones($params);
            break;
        }

        return $response;
    }

    public function clasificaciones(Request $request)
    {
        
        $params = Input::all();
            
        foreach ($params as $indices) {
            foreach ($indices as $datos) {

                $validator = Validator::make($datos, $this->rules_clasificacion);

                if($validator->fails()){
                    return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
                }
                else{ 
                
                    Clasificacion::where('id', '=', $datos['id'])
                    ->update([
                        'clasificacion_min' => $datos['clasificacion_min'],
                        'clasificacion_max' => $datos['clasificacion_max']
                    ]);
                }
            }
        }
        
        $result = Clasificacion::all();

        return response()->json($result);
        

    }

    public function config_general($params)
    {

        $validator = Validator::make($params, $this->rules_config);
        
        if($validator->fails()){
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        else{
            $jsonString = file_get_contents("json/config.json");
            $data = json_decode($jsonString, true);
            
            $data['vigencia'] = intval($params['vigencia']);
            $data['bono_inicio'] = intval($params['puntos_iniciales']);
            $data['tiempo_clasificacion'] = intval($params['reset_clasificacion']);
            
            $newJsonString = json_encode($data, JSON_PRETTY_PRINT);
            $result = file_put_contents("json/config.json", stripslashes($newJsonString));
            
            return "success";
        }
    }

    public function crea_ciudad($params)
    {
        
        $validator = Validator::make($params, $this->rules_ciudad);

        if($validator->fails()){
            $response = Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        else{
            $ciudad = new Ciudad();
            $ciudad->ciudad_nombre = $params['ciudad_nombre'];
            $ciudad->save();
            $response = $params;

            $response['empresas'] = Ciudad::all();
        }

        return $response;
    }

    public function crea_empresa($params){

        $validator = Validator::make($params, $this->rules_empresa);
        
        if ($validator->fails()) {
            $response = Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        else {
            
            $empresa = new Empresa();
            $empresa->empresa_nombre = $params['empresa_nombre'];
            $empresa->empresa_ubicacion = $params['empresa_ubicacion'];
            $empresa->empresa_cp = $params['empresa_cp'];
            $empresa->empresa_numero = $params['empresa_numero'];
            $empresa->ciudad_id = $params['empresa_ciudad'];
            $empresa->save();

            $ciudad = Ciudad::find($params['empresa_ciudad']);
            $params['ciudad_nombre'] = $ciudad->ciudad_nombre;

            $response = $params;
        }

        return $response;

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
        $jsonString = file_get_contents("json/config.json");

        $data = json_decode($jsonString, true);

        $data['vigencia'] = 0.66;

        $newJsonString = json_encode($data, JSON_PRETTY_PRINT);

        $result = file_put_contents("json/config.json", stripslashes($newJsonString));

        if($result){
            echo "correcto";
        }
        else{
            echo "fallo";
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $params = Input::all();
        
        foreach ($params as $indices) {
            foreach ($indices as $datos) {
                Empresa::where('id', '=', $datos['id'])
                ->update([
                    'empresa_nombre' => $datos['empresa_nombre'],
                    'empresa_ubicacion' => $datos['empresa_ubicacion'],
                    'empresa_cp' => $datos['empresa_cp'],
                    'empresa_numero' => $datos['empresa_numero']
                ]);
            }
        }
        
        $result = Empresa::with('ciudad')->get();

        return response()->json($result);

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
