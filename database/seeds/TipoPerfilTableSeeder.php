<?php

use Illuminate\Database\Seeder;

class TipoPerfilTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_perfiles')->insert([
            'tipo_perfil_nombre' => 'Personal',
            'tipo_perfil_porcentaje' => 0,
        ]);
        DB::table('tipo_perfiles')->insert([
            'tipo_perfil_nombre' => 'Ex Alumno',
            'tipo_perfil_porcentaje' => 5,
        ]);

        DB::table('tipo_perfiles')->insert([
            'tipo_perfil_nombre' => 'Docente',
            'tipo_perfil_porcentaje' => 5,
        ]);

        DB::table('tipo_perfiles')->insert([
            'tipo_perfil_nombre' => 'Alumno',
            'tipo_perfil_porcentaje' => 5,
        ]);

        DB::table('tipo_perfiles')->insert([
            'tipo_perfil_nombre' => 'Externo',
            'tipo_perfil_porcentaje' => 5,
        ]);

        DB::table('tipo_perfiles')->insert([
            'tipo_perfil_nombre' => 'Administrativo',
            'tipo_perfil_porcentaje' => 5,
        ]);
    }
}
