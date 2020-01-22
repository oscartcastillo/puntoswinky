<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

use Response;
use Validator;

use App\Promocion;
use App\Participante;
use App\Empresa;

class PromocionesController extends Controller
{
    
    public function __construct(){
        
        $this->middleware('auth');
    }


    protected function vali_insert($rol){

        $rules = array(
            'nombre' => 'required',
            'codigo' => 'required|min:1|max:100',
            'tipo' => 'required',
            'cantidad' => 'required|numeric|min:1|max:100',
            'repetir' => 'required',
            'color' => 'required',
            'inicio' => 'required',
            'fin' => 'required_if:repetir,==,D',
            'dias'=> 'sometimes|required',
            'estatus' => 'required'
        );
        
        if ($rol == 'admin' || $rol == 'super') {
            $empresa = array('empresas' => 'required');
            $rules = array_merge($rules , $empresa); 
        }
        return $rules;
    }

    protected function vali_update($rol, $id){

        $rules = array(
            'nombre' => 'required',
            'promocion_codigo' => 'required|min:1|max:100|unique:promociones,promocion_codigo,'.$id,
            'tipo' => 'required',
            'cantidad' => 'required|numeric|min:1|max:100',
            'repetir' => 'required',
            'color' => 'required',
            'inicio' => 'required',
            'fin' => 'required_if:repetir,==,D',
            'estatus' => 'required',
            'dias' => 'sometimes|required',
            'empresas' => 'required'
        );
        
        if ($rol == 'admin' || $rol == 'super') {
            $empresa = array('empresas' => 'required');
            $rules = array_merge($rules , $empresa); 
        }
        return $rules;
    }

    protected $dias_array = [
        '1' => 'lunes',
        '2' => 'martes',
        '3' => 'miércoles',
        '4' => 'jueves',
        '5' => 'viernes',
        '6' => 'sábado',
        '0' => 'domingo'
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $rol = Auth::User()->roles()->first()->name;
        switch ($rol) {
            case 'admin':
                $empresas_insert = Empresa::all();
                $promociones = Promocion::all();
            break;
            case 'super':
                $empresas_insert = Empresa::where('ciudad_id', '=', Auth::User()->perfil->ciudad_id)->get();
                $promociones = Promocion::where('ciudad_id', '=', Auth::User()->perfil->ciudad_id)->get();
            break;
            case 'geren':
            case 'cajero':
                $empresas_insert = Empresa::find(Auth::User()->perfil->empresa_id);
                $promociones = Promocion::join('participantes', 'participantes.promocion_id' , '=', 'promociones.id')
                    ->where('participantes.empresa_id', '=', Auth::User()->perfil->empresa_id)
                    ->get();
            break;
        }
        return view('admin.promociones', compact('promociones', 'empresas_insert'));
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
        
        $todo = $request->all();
        $rol = Auth::User()->roles()->first()->name;
        $validator = Validator::make(Input::all() , $this->vali_insert($rol));

        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        else {

            if (!is_null($request->dias)) {
                $dias = $request->dias;
                $dias_insert = [];
                $dias_name = [];
                foreach ($dias as $value) {
                    $clave = array_search($value, $this->dias_array);
                    array_push($dias_insert, $clave);
                    $name = $this->dias_array[$clave];
                    array_push($dias_name, $name);
                }
                $dias_n = implode(",", $dias_insert);
                $dias_nombre = implode(",",$dias_name);
            }
            else{
                $dias_n = '';
                $dias_nombre = '';
                $dias_null = '';
            }

            $promocion = new Promocion();
            $promocion->promocion_nombre = $request->nombre;
            $promocion->promocion_tipo = $request->tipo;
            $promocion->promocion_cantidad = $request->cantidad;
            $promocion->promocion_repetir = $request->repetir;
            $promocion->promocion_dias = $dias_n;
            $promocion->promocion_dias_nombre = $dias_nombre;
            $promocion->promocion_color = $request->color;
            $promocion->promocion_inicio = $request->inicio;
            $promocion->promocion_fin = $request->fin;
            $promocion->promocion_estatus = $request->estatus;
            $promocion->promocion_codigo = $request->codigo;
            $promocion->user_id = Auth::User()->id;
            $promocion->save();

            $data = array();
            if ($rol != 'geren') {
                
                $empresas = $request->empresas;
                foreach ($empresas as $value) {
                    $ciudad_id = Empresa::find($value)->ciudad->id;
                    $data[] = [
                        'ciudad_id' => $ciudad_id,
                        'empresa_id' => $value,
                        'promocion_id' => $promocion->id,
                    ];
                }
            }
            else{
                $ciudad_id = Auth::User()->perfil->ciudad_id;
                    $data[] = [
                        'ciudad_id' => $ciudad_id,
                        'empresa_id' => $value,
                        'promocion_id' => $promocion->id,
                    ];
            }
            $inser_esc = Participante::insert($data);

            $todo['promomo_id'] = $promocion->id;

            $todo['dias_id'] = $dias_n;

            if (isset($dias_null)) {
                $todo['dias'] = $dias_null;
            }
            return response()->json($todo);
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
        
        $todo = $request->all();
        $rol = Auth::User()->roles()->first()->name;
        $validator = Validator::make(Input::all() , $this->vali_update($rol, $id));
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        else{
            if (!is_null($request->dias)) {
                $dias = $request->dias;
                $dias_insert = [];
                $dias_name = [];
                foreach ($dias as $value) {
                    $clave = array_search($value, $this->dias_array);
                    array_push($dias_insert, $clave);
                    $name = $this->dias_array[$clave];
                    array_push($dias_name, $name);
                }
                $dias_n = implode(",", $dias_insert);
                $dias_nombre = implode(",",$dias_name);
            }
            else{
                $dias_n = '';
                $dias_nombre = '';
                $dias_null = '';
            }

            $promocion = Promocion::findOrFail($id);
            $promocion->promocion_nombre = $request->nombre;
            $promocion->promocion_tipo = $request->tipo;
            $promocion->promocion_cantidad = $request->cantidad;
            $promocion->promocion_repetir = $request->repetir;
            $promocion->promocion_dias = $dias_n;
            $promocion->promocion_dias_nombre = $dias_nombre;
            $promocion->promocion_color = $request->color;
            $promocion->promocion_inicio = $request->inicio;
            $promocion->promocion_fin = $request->fin;
            $promocion->promocion_estatus = $request->estatus;
            $promocion->promocion_codigo = $request->promocion_codigo;
            $promocion->push();
            $participante = Participante::where('promocion_id', $id)->delete();

            if ($participante == true) {
                $data = array();
                if ($rol != 'geren') {
                    $empresas = $request->empresas;
                    foreach ($empresas as $value) {
                        $ciudad_id = Empresa::find($value)->ciudad->id;
                        $data[] = [
                            'ciudad_id' => $ciudad_id,
                            'empresa_id' => $value,
                            'promocion_id' => $promocion->id,
                        ];
                    }
                }
                else{
                    $ciudad_id = Auth::User()->perfil->ciudad_id;
                    $data[] = [
                        'ciudad_id' => $ciudad_id,
                        'empresa_id' => $value,
                        'promocion_id' => $promocion->id,
                    ];
                }
                $inser_esc = Participante::insert($data);
                $todo['promomo_id'] = $promocion->id;
                $todo['dias_id'] = $dias_n;
                if (isset($dias_null)) {
                    $todo['dias'] = $dias_null;
                }
            }
            $todo['id'] = $id;
            return response()->json($todo);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
    
    }
    
    public function getempresas(){
        
        $data = Empresa::all();
        echo json_encode($data);
    }
}
