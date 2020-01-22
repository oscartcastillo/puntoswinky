<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

use Image;
use Response;
use Validator;
use File;

use App\Premio;
use App\Empresa;
use App\Ciudad;
use App\User;
use App\Transaccion;

class PremiosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $rules_a =
    [
        'imagen' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'nombre' => 'required',
        'descripcion' => 'required',
        'precio' => 'required',
        'stock' => 'required',
        'estatus' => 'required',
        'clasificacion' => 'required',
        'empresa' => 'required',
    ];

    protected $rules =
    [
        'imagen' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'nombre' => 'required',
        'descripcion' => 'required',
        'precio' => 'required',
        'stock' => 'required',
        'estatus' => 'required',
        'clasificacion' => 'required',
    ];

    public function index()
    {
        
        $rol = Auth::User()->roles()->first()->name;
        $empresas = '';
        switch ($rol) {
            case 'admin':
                $premios = Premio::all();
                $empresas = Empresa::all();
            break;
            case 'super':
                $premios = Premio::join('empresas', 'premios.empresa_id' , '=', 'empresas.id')
                    ->join('ciudades', 'empresas.ciudad_id', '=', 'ciudades.id')
                    ->where('ciudades.id', '=', Auth::User()->perfil->ciudad_id)
                    ->get();
                $empresas = Empresa::where('ciudad_id', '=', Auth::User()->perfil->ciudad_id)->get();
                
            break;
            
            case 'geren':
            case 'cajero':
                $premios = Premio::where('empresa_id', '=', Auth::User()->perfil->empresa_id)->get();
            break;
        }
        
        return view('admin.premios', compact('premios', 'empresas'));
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
        $rol = Auth::User()->roles()->first()->name;
        switch ($rol) {
            case 'admin':
            case 'super': 
                $validator = Validator::make(Input::all(), $this->rules_a);
                $empresa_id = $request->empresa;
            break;
            case 'geren':
            case 'cajero':
                $validator = Validator::make(Input::all(), $this->rules);
                $empresa_id = Auth::User()->perfil->empresa_id;
            break;
        }
        
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        else { 
            
            $input = Input::all();
            $file = array_get($input,'imagen');
            $fileName = $this->renombreimg($file, $imagen = '');

            $premio = new Premio();
            $premio->premio_nombre = $request->nombre;
            $premio->premio_descripcion = $request->descripcion;
            $premio->premio_imagen = $fileName;
            $premio->premio_precio = $request->precio;
            $premio->premio_stock = $request->stock;
            $premio->premio_estatus = $request->estatus;
            $premio->empresa_id = $empresa_id;
            $premio->clasificacion_id = $request->clasificacion;
            $premio->user_id = Auth::User()->id;
            $premio->save();
        }
        
        return Response()->json($premio);
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
    public function update(Request $request, $id){

        $rol = Auth::User()->roles()->first()->name;
        
        switch ($rol) {
            case 'admin':
            case 'super': 
                $validator = Validator::make(Input::all(), $this->rules_a);
                $empresa_id = $request->empresa;
            break;
            case 'geren':
            case 'cajero':
                $validator = Validator::make(Input::all(), $this->rules);
                $empresa_id = Auth::User()->perfil->empresa_id;
            break;
        }

        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        else {

            $input = Input::all();
            $file = array_get($input,'imagen');
            

            $premio = Premio::findOrFail($id);
            $premio->premio_nombre = $request->nombre;
            $premio->premio_descripcion = $request->descripcion;
            $premio->premio_precio = $request->precio;
            $premio->premio_stock = $request->stock;
            $premio->premio_estatus = $request->estatus;
            $premio->empresa_id = $empresa_id;
            $premio->clasificacion_id = $request->clasificacion;
            $premio->user_id = Auth::User()->id;
            $fileName = $this->renombreimg($file, $premio->premio_imagen);
            $premio->premio_imagen = $fileName;
            $premio->push();
        }
        return Response()->json($premio);
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

    public function listado_premios(){

        $transacciones = Transaccion::where('transaccion_tipo', '=', 'Por Premio')->get();

        return view('admin.listado_premios', compact('transacciones'));
        
    }

    public function renombreimg($file, $imagen){

        $destinationPath = 'uploads/';

        if(isset($file) && $imagen != ''){
            File::delete( $destinationPath . $imagen);
            $fileName = $imagen;
        }
        
        if(empty($file)){
            $fileName = $imagen;
        }
        
        if(isset($file)){
            
            $extension = $file->getClientOriginalExtension();
            $fecha = date_create();
            $rename = date_timestamp_get($fecha);
            $fileName = $rename . '.' . $extension;
            $file->move($destinationPath, $fileName);
        }

        return $fileName;
    }
}
