<?php

use Illuminate\Database\Seeder;
use App\Empresa;

class EmpresaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $empresa = new Empresa();
        $empresa->empresa_nombre = 'Calmecac';
        $empresa->empresa_ubicacion = '3 SUR COLONIA EL CERRITO';
        $empresa->empresa_cp = '72440';
        $empresa->empresa_numero = '2140601';
        $empresa->ciudad_id = 1;
        $empresa->save();

        $empresa = new Empresa();
        $empresa->empresa_nombre = 'Zocalo';
        $empresa->empresa_ubicacion = '3 SUR COLONIA EL CERRITO';
        $empresa->empresa_cp = '72440';
        $empresa->empresa_numero = '2140601';
        $empresa->ciudad_id = 2;
        $empresa->save();
    }
}
