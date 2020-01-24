<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\User;
use App\Perfil;
use App\Bono;
use App\Clasificacion;
use App\Transaccion;

use File;


class PruebasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = File::get("json/config.json");
        $json = json_decode($data, true);
        $vigencia = $json['vigencia'];

        $users = User::where([
            ['estatus','A'],
            ['name','cliente']
        ])->get();

        $now = Carbon::now();
        
        foreach ($users as $user){
            
            $created = new Carbon($user->created_at);
            $difference = $created->diff($now);
            $numero_meses = ($difference->y > 0 ) ? 12 : $difference->m;

            if($numero_meses == $vigencia && $difference->d == 0 $numero_meses != null){
                Transaccion::where([
                    ['user_id', $user->id],
                    ['transaccion_estatus', 'Activo']
                ])->update(['transaccion_estatus' => 'Inactivo']);
            }
        }
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
        //
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
