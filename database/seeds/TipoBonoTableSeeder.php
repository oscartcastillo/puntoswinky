<?php

use Illuminate\Database\Seeder;
use App\TipoBono;

class TipoBonoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipo_bono = new TipoBono();
        $tipo_bono->tipo_bono_nombre = 'Mensual Todas Comidas';
        $tipo_bono->save();

        $tipo_bono = new TipoBono();
        $tipo_bono->tipo_bono_nombre = 'Mensual Solo Comida';
        $tipo_bono->save();

        $tipo_bono = new TipoBono();
        $tipo_bono->tipo_bono_nombre = 'Semanal Todas Comidas';
        $tipo_bono->save();

        $tipo_bono = new TipoBono();
        $tipo_bono->tipo_bono_nombre = 'Semanal Solo Comida';
        $tipo_bono->save();
    }
}
