<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class VigenciaPuntos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vigencia:puntos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizar vigencia de los puntos';

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
        $vigencia = $json['vigencia'];

        $users = User::where([
            ['estatus','A'],
            ['name','cliente']
        ])->get();

        $now = Carbon::now();
        
        foreach ($users as $user){
            
            $created = new Carbon($user->puntos_reset);
            $difference = $created->diff($now);
            
            $meses = ($difference->y * 12) + $difference->m;

            if($meses == $vigencia && $difference->d == 0){
                
                $transaccion = Transaccion::where([
                    ['user_id', $user->id],
                    ['transaccion_estatus', 'Activo']
                ])->update(['transaccion_estatus' => 'Inactivo']);

                if ($transaccion){
                    User::where('id', $user->id)
                    ->update([
                        'puntos_reset' => $now
                    ]);
                }
            }
        }
    }
}
