<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;

use App\Exports\UsersExport;

use Validator;
use Response;
use PDF;
use Excel;

use App\User;
use App\Premio;
use App\Perfil;
use App\Ciudad;
use App\Empresa;
use App\Transaccion;


class UsuariosController extends Controller
{

    //pub $dt = new Carbon\Carbon();
    //pub $today = $dt->today();
    //protected $tomorrow = $dt->tomorrow();

    //$rules = [ ... 'birth_date' => 'required|date|before:'.$today.'|after:01-jan-1920', 'another_date' => 'required|date|before:'.$tomorrow.'|after:01-jan-1990' ];

    //reglas administrador y supervisor
    protected $rules_a_s =
    [
        'rol'=> 'required',
        'email' => 'required|email|unique:users',
        'estatus'=> 'required',
        'ciudad' => 'required',
        'empresa' => 'required',
        'cumpleanos' => 'before:2010-01-01|after:1950-01-01',
        'nombre'      => 'required|min:2|max:30|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
        'apellidos'      => 'required|min:2|max:30|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
        'genero'=> 'required'

    ];

    //reglas gerente
    protected $rules_g_c =
    [
        'rol'=> 'required',
        'email' => 'required|email|unique:users',
        'estatus'=> 'required',
        'genero'=> 'required',
        'cumpleanos' => 'before:2010-01-01|after:1950-01-01',
        'nombre'      => 'required|min:2|max:30|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
        'apellidos'      => 'required|min:2|max:30|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/'
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function inicio(){

        if (Auth::User()->roles()->first()->name == 'cliente') {
            
            $puntos = User::join('transacciones', 'users.id' , '=', 'transacciones.user_id')
                ->where('transacciones.user_id', '=', Auth()->user()->id)
                ->sum('transacciones.transaccion_abono');

            $datos = Transaccion::where('user_id', '=', Auth()->user()->id)
                ->get();

            $premios = Premio::where([
                ['clasificacion_id', '=', Auth::User()->perfil->clasificacion_id],
                ['premio_stock', '>', 0],
            ])->get();

            return view('admin/inicio', compact('puntos', 'datos', 'premios'));
        }
        else{
            
            //consulta solo clientes
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
            //Carbon::setWeekStartsAt(Carbon::SUNDAY);
            $clientes_semana = DB::table('users as sc')
            ->where('name', '=', 'cliente')
            ->whereBetween('sc.created_at', [Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])
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

            $data = array(
                'clientes' => $clientes,
                'clientes_totales' => $clientes_t,
                'clientes_dia' => $clientes_dia,
                'clientes_semana' => $clientes_semana,
                'clientes_mes' => $clientes_mes,
                'clientes_sin_tarjeta' => $clientes_sin_tarjeta,
                'puntos_utilizados_mes' => $puntos_utilizados_mes * -1,
                'premios_otorgados_mes' => $premios_otorgados_mes,
                'cancelaciones_mes' => $cancelaciones_mes
            );
            
            return view('admin/principal', compact('data'));
        }
    }

    public function index(){

        $ciudades = Ciudad::get();
        $empresas = Empresa::get();
        $rol = Auth::User()->roles()->first()->name;

        switch ($rol) {
            case 'admin':
                $empleados = User::whereHas(
                    'roles', function($emp){
                        $emp->where('name', '!=', 'cliente');
                    }
                )->get();
            break;
            case 'super':
                $empleados = User::whereHas(
                    'roles', function($emp){
                        $emp->whereIn('name',  ['geren', 'cajero']);
                    }
                )->whereHas(
                    'perfil', function ($c) {
                        $c->where('ciudad_id', '=', Auth::user()->perfil->ciudad_id);
                    }
                )->get();
            break;
            case 'geren':
                $empleados = User::whereHas(
                    'roles', function($emp){
                        $emp->where('name', 'cajero');
                    }
                )->whereHas(
                    'perfil', function ($c) {
                        $c->where('ciudad_id', '=', Auth::user()->perfil->ciudad_id);
                    }
                )->get();
            break;
            case 'cajero':
                $empleados = '';
            break;
        }
        //return $empleados;
        return view('admin.usuarios',compact('empleados', 'ciudades', 'empresas'));
        
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
    public function store(Request $request){

        $todo = $request->all();
        $rol = Auth::User()->roles()->first()->name;
        switch ($rol) {
            case 'admin':
            case 'super': 
                $validator = Validator::make(Input::all(), $this->rules_a_s);
                $bandera = 1;
            break;
            case 'geren':
            case 'cajero':
                $validator = Validator::make(Input::all(), $this->rules_g_c);
                $bandera = 0;
            break;
        }
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        else {
            
            //Crear Usuario
            $user = new User();
            $user->name= $request->rol;
            $user->email = strtolower($request->email);
            $user->password = Hash::make(Input::get('winkyfan'));
            $user->estatus = $request->estatus;
            $user->puntos_reset = Carbon::now()->format('Y-m-d');
            $user->save();

            $tarjeta_new = str_pad($user->id, 12, "0", STR_PAD_LEFT);

            //Crear Perfil
            $perfil = new Perfil();
            $perfil->perfil_nombre = strtolower($request->nombre);
            $perfil->perfil_apellidos = strtolower($request->apellidos);
            $perfil->perfil_tarjeta = $tarjeta_new;
            $perfil->perfil_genero = $request->genero;
            $perfil->avatar_id = 0;
            $perfil->perfil_nacimiento = $request->cumpleanos;
            $perfil->perfil_celular = $request->telefono;
            $perfil->tipo_perfil_id = 1;

            if ($bandera == 0) {
                $perfil->empresa_id = Auth::User()->perfil->empresa_id;
                $perfil->ciudad_id = Auth::User()->perfil->ciudad_id;
            }
            else{
                $perfil->empresa_id = $request->empresa;
                $perfil->ciudad_id = $request->ciudad;
            }
            
            $perfil->vendedor_id = Auth::User()->id;
            $perfil->user_id = $user->id;
            $perfil->save();

            //Asignar Rol
            $user->assignRole($request->rol);

            $ciudad_n = Ciudad::select('ciudad_nombre')->where('id', '=', $perfil->ciudad_id)->first();
            $empresa_n = Empresa::select('empresa_nombre')->where('id','=', $perfil->empresa_id)->first();

            $todo['id'] = $user->id;
            $todo['ciudad_nombre'] = $ciudad_n->ciudad_nombre;
            $todo['empresa_nombre'] = $empresa_n->empresa_nombre;

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
        $user = User::find($id);
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        $rol = Auth::User()->roles()->first()->name;
        switch ($rol) {
            case 'admin':
            case 'super':
                $validator = Validator::make($request->all(), [
                    'rol'        => 'required',
                    'email'      => 'required|email|unique:users,email,'.$id,
                    'estatus'    => 'required',
                    'ciudad'     => 'required',
                    'telefono'   => 'min:7|max:12',
                    'cumpleanos' => 'before:2010-01-01|after:1950-01-01',
                    'empresa'    => 'required',
                    'nombre'     => 'required|min:2|max:30|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
                    'apellidos'  => 'required|min:2|max:30|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/'
                ]);
                $bandera = 1;
            break;
            case 'geren':
                $validator = Validator::make($request->all(), [
                    'rol'=> 'required',
                    'estatus'    => 'required',
                    'nombre'     => 'required|min:2|max:30|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
                    'apellidos'  => 'required|min:2|max:30|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
                    'cumpleanos' => 'before:2010-01-01|after:1950-01-01',
                    'email'      => 'required|email|unique:users,email,'.$id,
                    'genero'     => 'required'
                ]);
                $bandera = 0;
            break;
        }
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        else{
            
            $user = User::findOrFail($id);
            $user->name = $request->rol;
            $user->email = $request->email;
            $user->estatus = $request->estatus;
            
            $user->perfil->perfil_nombre = $request->nombre;
            $user->perfil->perfil_apellidos = $request->apellidos;
            $user->perfil->perfil_genero = $request->genero;
            $user->perfil->perfil_nacimiento = $request->cumpleanos;
            $user->perfil->perfil_celular = $request->telefono;

            if ($bandera == 1) {
                $user->perfil->empresa_id = $request->empresa;
                $user->perfil->ciudad_id = $request->ciudad;
            }
            else{
                $user->perfil->empresa_id = Auth::user()->perfil->empresa_id;
                $user->perfil->ciudad_id = Auth::user()->perfil->ciudad_id;
            }
            
            $user->push();

            $id_rol = \DB::table('roles')->select('id')->where('name','=', $request->rol)->first();
            
            $user->roles()->sync($id_rol);

            if ($bandera == 1) {
                $ciudad_n = Ciudad::select('ciudad_nombre')->where('id', $user->perfil->ciudad_id )->first();
                $empresa_n = Empresa::select('empresa_nombre')->where('id', $user->perfil->empresa_id)->first();
                $user['ciudad_nombre'] = $ciudad_n->ciudad_nombre;
                $user['empresa_nombre'] = $empresa_n->empresa_nombre;
            }
            $user['rol_id'] = $rol;
            
            return response()->json($user); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::destroy($id);
        return response()->json($user);
    }

    public function export_pdf(){


        $rol = Auth::User()->roles()->first()->name;

        switch ($rol) {
            case 'admin':
                $empleados = User::whereHas(
                    'roles', function($emp){
                        $emp->where('name', '!=', 'cliente');
                    }
                )->get();
            break;
            case 'super':
                $empleados = User::whereHas(
                    'roles', function($emp){
                        $emp->whereIn('name',  ['geren', 'cajero']);
                    }
                )->whereHas(
                    'perfil', function ($c) {
                        $c->where('ciudad_id', '=', Auth::user()->perfil->ciudad_id);
                    }
                )->get();
            break;
            case 'geren':
                $empleados = User::whereHas(
                    'roles', function($emp){
                        $emp->where('name', 'cajero');
                    }
                )->whereHas(
                    'perfil', function ($c) {
                        $c->where('ciudad_id', '=', Auth::user()->perfil->ciudad_id);
                    }
                )->get();
            break;
            case 'cajero':
                $empleados = '';
            break;
        }
        $pdf = PDF::loadView('admin.reportes.empleados_pdf', compact('empleados'));
        return $pdf->download('empleados.pdf');
    }

    public function export_excel() {
        return Excel::download(new UsersExport, 'usuarios.xlsx');
    }

    public function getEmpresa(Ciudad $ciudad){
        return $ciudad->empresas()->select('id', 'empresa_nombre')->get();
    }

}
