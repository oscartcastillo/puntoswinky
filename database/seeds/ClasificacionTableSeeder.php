<?php

use Illuminate\Database\Seeder;

class ClasificacionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('clasificaciones')->insert([
    		'id' => '1',
    		'clasificacion_nombre' => 'basica',
    		'clasificacion_min' => '0', //min de visitas
    		'clasificacion_max' => '20', //max de visitas
    	]);

    	DB::table('clasificaciones')->insert([
    		'id' => '2',
    		'clasificacion_nombre' => 'media',
    		'clasificacion_min' => '21', //min de visitas
    		'clasificacion_max' => '30', //max de visitas
    	]);

    	DB::table('clasificaciones')->insert([
    		'id' => '3',
    		'clasificacion_nombre' => 'premium',
    		'clasificacion_min' => '31', //min de visitas
    		'clasificacion_max' => '100', //max de visitas
    	]);
    }
}
