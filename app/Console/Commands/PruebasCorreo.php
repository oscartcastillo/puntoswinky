<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
//use Illuminate\Support\Facades\Mail;
//use App\Mail\CumpleMail;
use App\Bono;
use Carbon\Carbon;

class PruebasCorreo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pruebas:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar correo de prueba';

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
        $bonos =  Bono::whereDate('bono_fin', '<', Carbon::today()->toDateString())->get();
        foreach ($bonos as $bono) {
            $bono->bono_estatus = 'vencido';
            $bono->push();
        }
        //Mail::to('murdokcas@gmail.com')->send(new CumpleMail($prueba));
    }
}
