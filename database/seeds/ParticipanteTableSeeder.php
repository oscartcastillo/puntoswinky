<?php

use Illuminate\Database\Seeder;

class ParticipanteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('participantes')->insert([
            'ciudad_id' => '1',
            'empresa_id' => '1',
            'promocion_id' => '1',
        ]);

        DB::table('participantes')->insert([
            'ciudad_id' => '2',
            'empresa_id' => '2',
            'promocion_id' => '1',
        ]);

        DB::table('participantes')->insert([
            'ciudad_id' => '1',
            'empresa_id' => '1',
            'promocion_id' => '2',
        ]);

        DB::table('participantes')->insert([
            'ciudad_id' => '2',
            'empresa_id' => '2',
            'promocion_id' => '2',
        ]);
    }
}
