<?php

use Illuminate\Database\Seeder;
use App\Tiempo;

class TiempoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tiempo = new Tiempo();
        $tiempo->tiempo_nombre = 'Desayuno';
        $tiempo->save();

        $tiempo = new Tiempo();
        $tiempo->tiempo_nombre = 'Comida';
        $tiempo->save();

        $tiempo = new Tiempo();
        $tiempo->tiempo_nombre = 'Cena';
        $tiempo->save();

    }
}
