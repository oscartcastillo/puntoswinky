<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\VigenciaPuntos',
        'App\Console\Commands\VigenciaBonos',
        'App\Console\Commands\VigenciaClasificacion',
        'App\Console\Commands\CorreCumpleanos',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('vigencia:puntos')->dailyAt('07:20');
        $schedule->command('vigencia:bonos')->dailyAt('07:30');
        $schedule->command('vigencia:clasificacion')->dailyAt('07:40');
        $schedule->command('correo:cumpleanos')->dailyAt('07:50');
        //$schedule->command('cumple:users')->daily()->at('17:40');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
