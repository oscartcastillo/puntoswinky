<?php

use Illuminate\Database\Seeder;
use App\Tipo_Promocion;

class TipoPromocionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_promocion')->insert([
            'nombre' => 'aniversario',
        ]);

        DB::table('tipo_promocion')->insert([
            'nombre' => 'cumpleaños',
        ]);
    }
}
