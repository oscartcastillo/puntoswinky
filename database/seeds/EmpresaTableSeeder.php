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
        $empresa->empresa_nombre = 'Winky';
        $empresa->empresa_ubicacion = 'Calle 3 Sur 5758 El Cerrito';
        $empresa->empresa_cp = '72440';
        $empresa->empresa_numero = '222 214 0601';
        $empresa->ciudad_id = 1;
        $empresa->save();
    }
}
