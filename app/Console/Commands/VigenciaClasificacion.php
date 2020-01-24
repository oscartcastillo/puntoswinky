<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\User;
use App\Perfil;
use App\Bono;
use App\Clasificacion;
use App\Transaccion;
use File;

class VigenciaClasificacion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vigencia:clasificacion';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizar clasificacion de los clientes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = File::get("json/config.json");
        $json = json_decode($data, true);
        $reset_clasificacion = $json['tiempo_clasificacion'];

        $users = User::where([
            ['estatus','A'],
            ['name','cliente']
        ])->get();

        $now = Carbon::now();
        
        foreach ($users as $user){
            
            $created = new Carbon($user->created_at);
            
            $difference = $created->diff($now);
            $residuo = $difference->m % 3;

            if ($difference->d == 0 && $residuo == 0){
                $puntos = $this->obten_puntos($user->id);
                $clasificacion_id = $this->obten_clasificacion($puntos);
                
                Perfil::where('user_id', $user->id)->update(['perfil_clasificaicon' => $clasificacion_id]);

                /*Transaccion::where([
                    ['user_id', $user->id],
                    ['transaccion_estatus', 'Activo']
                ])->update(['transaccion_estatus' => 'Inactivo']);*/
            }
        }
    }
    public function obten_clasificacion($puntos){

        $clasicaciones = Clasificacion::all();
        foreach($clasicaciones as $clasicacion){
            if($clasicacion->clasificacion_min <= $puntos && $clasicacion->clasificacion_max >= $puntos){
                $valor = $clasicacion->id;
            }
        }
        return $valor;
    }

    public function obten_puntos($id){
        $puntos = User::join('transacciones', 'users.id' , '=', 'transacciones.user_id')
            ->where([
                ['transacciones.user_id', '=', $id],
                ['transacciones.transaccion_tipo', '!=', 'Cancelacion'],
                ['transacciones.transaccion_estatus', 'Activo']
            ])
            ->sum('transacciones.transaccion_abono');

        return $puntos;
    }
}
