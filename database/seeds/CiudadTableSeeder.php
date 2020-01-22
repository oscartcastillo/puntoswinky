<?php

use Illuminate\Database\Seeder;
use App\Ciudad;

class CiudadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ciudad = new Ciudad();
        $ciudad->ciudad_nombre = 'Puebla';
        $ciudad->save();

        $ciudad = new Ciudad();
        $ciudad->ciudad_nombre = 'Tehuacan';
        $ciudad->save();
    }
}
