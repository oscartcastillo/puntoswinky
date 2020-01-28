<?php

use Illuminate\Database\Seeder;
use App\Perfil;

class PerfilTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $perfil = new Perfil();
        $perfil->perfil_nombre = 'oscar';
        $perfil->perfil_apellidos = 'castillo';
        $perfil->perfil_tarjeta = '000000000001';
        $perfil->perfil_genero = 'M';
        $perfil->perfil_nacimiento = '1993-02-25';
        $perfil->perfil_celular = NULL;
        $perfil->perfil_compania = NULL;
        $perfil->avatar_id = 0;
        $perfil->tipo_perfil_id = 1;
        $perfil->clasificacion_id = NULL;
        $perfil->empresa_id = 1;
        $perfil->ciudad_id = 1;
        $perfil->vendedor_id = 1;
        $perfil->user_id = 1;
        $perfil->created_at = NULL;
        $perfil->updated_at = NULL;
        $perfil->save();

        $perfil = new Perfil();
        $perfil->perfil_nombre = 'jeison';
        $perfil->perfil_apellidos = 'jeison';
        $perfil->perfil_tarjeta = '000000000002';
        $perfil->perfil_genero = 'M';
        $perfil->perfil_nacimiento = '1992-04-24';
        $perfil->perfil_celular = NULL;
        $perfil->perfil_compania = NULL;
        $perfil->avatar_id = 0;
        $perfil->tipo_perfil_id = 1;
        $perfil->clasificacion_id = NULL;
        $perfil->empresa_id = 1;
        $perfil->ciudad_id = 2;
        $perfil->vendedor_id = 1;
        $perfil->user_id = 2;
        $perfil->created_at = NULL;
        $perfil->updated_at = NULL;
        $perfil->save();
        
        $perfil = new Perfil();
        $perfil->perfil_nombre = 'arturo';
        $perfil->perfil_apellidos = 'castellan';
        $perfil->perfil_tarjeta = '000000000003';
        $perfil->perfil_genero = 'M';
        $perfil->perfil_nacimiento = '1990-05-20';
        $perfil->perfil_celular = NULL;
        $perfil->perfil_compania = NULL;
        $perfil->avatar_id = 0;
        $perfil->tipo_perfil_id = 1;
        $perfil->clasificacion_id = NULL;
        $perfil->empresa_id = 1;
        $perfil->ciudad_id = 1;
        $perfil->vendedor_id = 1;
        $perfil->user_id = 3;
        $perfil->created_at = NULL;
        $perfil->updated_at = NULL;
        $perfil->save();

        $perfil = new Perfil();
        $perfil->perfil_nombre = 'Guillermo';
        $perfil->perfil_apellidos = 'Contreras Chavez';
        $perfil->perfil_tarjeta = '000000000004';
        $perfil->perfil_genero = 'M';
        $perfil->perfil_nacimiento = '1980-08-14';
        $perfil->perfil_celular = NULL;
        $perfil->perfil_compania = NULL;
        $perfil->avatar_id = 0;
        $perfil->tipo_perfil_id = 1;
        $perfil->clasificacion_id = NULL;
        $perfil->empresa_id = 1;
        $perfil->ciudad_id = 1;
        $perfil->vendedor_id = 1;
        $perfil->user_id = 4;
        $perfil->created_at = NULL;
        $perfil->updated_at = NULL;
        $perfil->save();

        $perfil = new Perfil();
        $perfil->perfil_nombre = 'Miguel';
        $perfil->perfil_apellidos = 'Hernandez Meneses';
        $perfil->perfil_tarjeta = '000000000005';
        $perfil->perfil_genero = 'M';
        $perfil->perfil_nacimiento = '1996-08-23';
        $perfil->perfil_celular = '2555212125';
        $perfil->perfil_compania = 'telcel';
        $perfil->avatar_id = 0;
        $perfil->tipo_perfil_id = 2;
        $perfil->clasificacion_id = '1';
        $perfil->empresa_id = 1;
        $perfil->ciudad_id = 1;
        $perfil->vendedor_id = 1;
        $perfil->user_id = 5;
        $perfil->created_at = NULL;
        $perfil->updated_at = NULL;
        $perfil->save();
    }
}
