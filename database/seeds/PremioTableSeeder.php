<?php

use Illuminate\Database\Seeder;

class PremioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('premios')->insert([
            'premio_nombre' => 'taza 1',
            'premio_descripcion' => 'taza modelo 1',
            'premio_imagen' => 'premio.png',
            'premio_precio' => 40,
            'premio_stock' => 5,
            'premio_estatus' => 'A',
            'empresa_id' => 1,
            'clasificacion_id' => 1,
            'user_id' => 1,
        ]);

        DB::table('premios')->insert([
            'premio_nombre' => 'taza 2',
            'premio_descripcion' => 'taza modelo 2',
            'premio_imagen' => 'premio.png',
            'premio_precio' => 40,
            'premio_stock' => 2,
            'premio_estatus' => 'A',
            'empresa_id' => 1,
            'clasificacion_id' => 1,
            'user_id' => 1,
        ]);
    }
}
