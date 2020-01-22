<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use Response;
use Validator;

use App\User;
use App\Perfil;

class PerfilController extends Controller
{

    protected $rules = 
    [
        'password_anterior' => 'required',
        'password_nueva' => 'required|min:5',
        'password_repetir' => 'required|same:password_nueva'
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $avatar_id = Auth::User()->perfil->avatar_id;
        return view('admin/perfil', compact('avatar_id'));
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

        Perfil::where('id', '=', Auth::User()->id)
            ->update([
                'avatar_id' => $request->avatar
            ]);
        
        $result = [
            'avatar' => $request->avatar,
        ];
        
        return response()->json($result);
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

    public function pass(Request $request)
    {

        $validation = Validator::make(Input::all(), $this->rules);
        
        if ($validation->fails()){
            
            return Response::json(array('errors' => $validation->getMessageBag()->toArray()));
        }
        else{

            if (Hash::check($request->password_anterior, Auth::user()->password))
            {
                
                $cliente = new User();
                $cliente = Auth::User();
                $cliente->password = Hash::make(Input::get('password_nueva'));
                $cliente->save();

                if($cliente){
                    $result = [
                        'response' => 'correcto'
                    ];
                }
                else
                {
                    $result = [
                        'errors' => array(
                            'fail' => 'Ocurrio un errror'
                        )
                    ];
                }
            }
            else
            {
                $result = [
                    'errors' => array(
                        'incorrecta' => 'La contraseña actual no es correcta'
                    )
                ];
            }

            return response()->json($result);
        }
    }
}
