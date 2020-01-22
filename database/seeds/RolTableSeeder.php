<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('roles')->insert([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        DB::table('roles')->insert([
            'name' => 'super',
            'guard_name' => 'web',
        ]);

        DB::table('roles')->insert([
            'name' => 'geren',
            'guard_name' => 'web',
        ]);

        DB::table('roles')->insert([
            'name' => 'cajero',
            'guard_name' => 'web',
        ]);

        DB::table('roles')->insert([
            'name' => 'cliente',
            'guard_name' => 'web',
        ]);
    }
}
