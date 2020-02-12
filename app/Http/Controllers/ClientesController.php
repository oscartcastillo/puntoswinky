<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;

use App\Exports\ClientesExport;
use App\Mail\WelcomeMail;

use Validator;
use Response;
use PDF;
use Excel;

use App\User;
use App\Perfil;
use App\Ciudad;
use App\Empresa;
use App\Transaccion;


class ClientesController extends Controller
{
    protected $rules =
    [
        'email' => 'required|email|unique:users',
        'estatus'=> 'required',
        'nombre'=> 'required',
        'apellidos'=> 'required',
        'genero'=> 'required',
        'perfil_tarjeta' => 'unique:perfiles',
        'telefono' => 'required|digits:10',
        'compania' => 'required',
        'tipo' => 'required',
        'cumpleanos' => 'required'
    ];
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = User::whereHas(
            'roles', function($clie){
                $clie->where('name', '=', 'cliente');
            }
        )->get();

        return view('admin.clientes',compact('clientes'));
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
        $validator = Validator::make(Input::all(), $this->rules);

        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        else {
            
            //Crear Usuario
            $user = new User();
            $user->name = 'cliente';
            $user->email = strtolower($request->email);
            $user->password = Hash::make(Input::get('winkyfan'));
            $user->estatus = $request->estatus;
            $user->puntos_reset = Carbon::now()->format('Y-m-d');
            $user->save();

            if (is_null($request->perfil_tarjeta) ) {
                $tarjeta_new = str_pad($user->id, 12, "0", STR_PAD_LEFT);
            }
            else{
                $tarjeta_new = $request->perfil_tarjeta;
            }
            
            //Crear Perfil
            $perfil = new Perfil();
            $perfil->perfil_nombre = strtolower($request->nombre);
            $perfil->perfil_apellidos = strtolower($request->apellidos);
            $perfil->perfil_tarjeta = $tarjeta_new;
            $perfil->perfil_genero = $request->genero;
            $perfil->perfil_nacimiento = $request->cumpleanos;
            $perfil->perfil_celular = $request->telefono;
            $perfil->perfil_compania = $request->compania;
            $perfil->avatar_id = 0;
            $perfil->tipo_perfil_id = $request->tipo;
            $perfil->clasificacion_id = 1;
            $perfil->empresa_id = Auth::User()->perfil->empresa_id;
            $perfil->ciudad_id = Auth::User()->perfil->ciudad_id;
            $perfil->vendedor_id = Auth::User()->id;
            $perfil->user_id = $user->id;
            $perfil->save();

            //Asignar Rol
            $user->assignRole('cliente');
            $todo['id'] = $user->id;

            //Mail::to('murdokcas@gmail.com')->send(new WelcomeMail($user));
            $todo['tarjeta'] = $tarjeta_new;

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

        //$clave = $request->perfil_tarjeta;
        
        $validator = Validator::make($request->all(), [
            
            'email' => 'required|email|unique:users,email,'.$id,
            'estatus'=> 'required',
            'nombre'=> 'required',
            'apellidos'=> 'required',
            'genero'=> 'required',
            'perfil_tarjeta' => Rule::unique('perfiles')->ignore($request->perfil_tarjeta, 'perfil_tarjeta'),
            'telefono' => 'required',
            'compania' => 'required',
            'tipo' => 'required',
            'cumpleanos' => 'required'
        ]);

        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        else{

            $tar_new = str_pad($id, 12, "0", STR_PAD_LEFT);


            if (is_null($request->perfil_tarjeta)) {

                $tarjeta_edit = $tar_new;
            }
            else{
                
                $tarjeta_edit = $request->perfil_tarjeta;
            }
            
            $user = User::findOrFail($id);
            $user->email = $request->email;
            $user->estatus = $request->estatus;
            $user->perfil->perfil_nombre = strtolower($request->nombre);
            $user->perfil->perfil_apellidos = strtolower($request->apellidos);
            $user->perfil->perfil_tarjeta = $tarjeta_edit;
            $user->perfil->perfil_genero = $request->genero;
            $user->perfil->perfil_nacimiento = $request->cumpleanos;
            $user->perfil->perfil_celular = $request->telefono;
            $user->perfil->perfil_compania = $request->compania;
            $user->perfil->tipo_perfil_id = $request->tipo;
            $user->push();
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
        //
    }

    public function reglas(){

        return view('admin.reglas');
    }

    public function export_pdf(){

        $clientes = User::select('users.*', DB::raw('(CASE WHEN LENGTH(perfiles.perfil_tarjeta) > 10 then "" ELSE "NoTarjeta" END) AS tarjeta'))
        ->join('perfiles', 'perfiles.user_id','=','users.id')
        ->whereHas(
            'roles', function($clie){
                $clie->where('name', '=', 'cliente');
            }
        )->get();

        $pdf = PDF::loadView('admin.reportes.clientes_pdf', compact('clientes'));
        return $pdf->download('clientes.pdf');
    }

    public function export_excel() {
        return Excel::download(new ClientesExport, 'clientes.xlsx');
    }

    public function bienvenida($user){
        
        $subject = "Asunto del correo";
        $for = "correo_que_recibira_el_mensaje@gmail.com";
        Mail::send('email',$request->all(), function($msj) use($subject,$for){
            $msj->from("tucorreo@gmail.com","NombreQueApareceráComoEmisor");
            $msj->subject($subject);
            $msj->to($for);
        });
        return redirect()->back();
    }

}
