<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\CumpleMail;
use Carbon\Carbon;
use App\User;

class CorreCumpleanos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'correo:cumpleanos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar correo por cumpleaños';

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
        $clientes = User::join('perfiles', 'perfiles.user_id', '=', 'users.id')
            ->where([
                ['users.estatus', '!=', 'B'],
                ['users.name', 'cliente']
            ])
            ->whereRaw('DATE_FORMAT(perfiles.perfil_nacimiento, "%m-%d") = ?', [Carbon::now()->format('m-d')])
            ->get();


        foreach ($clientes as $cliente){
            Mail::to($cliente->email)->send(new CumpleMail($cliente));
        }
    }
}
