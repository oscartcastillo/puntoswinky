<?php

use Illuminate\Database\Seeder;
use App\Bono;

class BonoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $bono = new Bono();
        $bono->bono_inicio = '2019-11-13';
        $bono->bono_fin = '2019-10-19';
        $bono->tipo_bono_id = 1;
        $bono->user_id = 5;
        $bono->vendedor_id = 1;
        $bono->empresa_id = 1;
        $bono->bono_estatus = 'activo';
        $bono->save();

    }
}