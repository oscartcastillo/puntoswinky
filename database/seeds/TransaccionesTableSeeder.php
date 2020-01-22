<?php

use Illuminate\Database\Seeder;

class TransaccionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('transacciones')->insert([
            'transaccion_ticket' => '186408',
            'transaccion_fecha' => '2019-11-10',
            'transaccion_cantidad' => '24.00',
            'transaccion_puntos_extras' => NULL,
            'transaccion_descripcion' => NULL,
            'transaccion_abono' => '1.20',
            'transaccion_tipo' => 'Acumulados',
            'premio_id' => NULL,
            'promocion_id' => '1',
            'empresa_id' => '1',
            'vendedor_id' => '4',
            'cancelacion_descripcion' => NULL,
            'cancelacion_id' => NULL,
            'user_id' => '5',
        ]);
    }
}
