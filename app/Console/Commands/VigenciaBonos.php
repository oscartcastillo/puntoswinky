<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Bono;

class VigenciaBonos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vigencia:bonos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizar la vigencia de los bonos';

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
        
        $bonos = Bono::where([
            ['bono_estatus', 'activo'],
            ['bono_fin','=',Carbon::now()->format('y-m-d')]
        ])
        ->get();

        foreach ($bonos as $bono){
            
            Bono::where('id', $bono->id)
                ->update([
                    'bono_estatus' => 'vencido',
                ]);
        
        }
    }
}
