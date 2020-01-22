<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = new User();
        $user->name = 'admin';
        $user->email = 'admin@gmail.com';
        $user->estatus = 'A';
        $user->password = bcrypt('secret');
        $user->save();
        $user->assignRole('admin');

        $user = new User();
        $user->name = 'super';
        $user->email = 'super@gmail.com';
        $user->estatus = 'A';
        $user->password = bcrypt('secret');
        $user->save();
        $user->assignRole('super');

        $user = new User();
        $user->name = 'geren';
        $user->email = 'geren@gmail.com';
        $user->estatus = 'A';
        $user->password = bcrypt('secret');
        $user->save();
        $user->assignRole('geren');

        $user = new User();
        $user->name = 'cajero';
        $user->email = 'caje@gmail.com';
        $user->estatus = 'A';
        $user->password = bcrypt('secret');
        $user->save();
        $user->assignRole('cajero');

        $user = new User();
        $user->name = 'cliente';
        $user->email = 'cliente@gmail.com';
        $user->estatus = 'A';
        $user->password = bcrypt('secret');
        $user->save();
        $user->assignRole('cliente');
    }
}
