<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\User;
use Carbon\Carbon;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $hoy = date('Y-m-d');

        $user = new User();
        $user->name = 'admin';
        $user->email = 'pgil@uvp.mx';
        $user->estatus = 'A';
        $user->password = bcrypt('12Puebla34');
        $user->puntos_reset = Carbon::today();
        $user->save();
        $user->assignRole('admin');

        $user = new User();
        $user->name = 'admin';
        $user->email = 'lacafe@uvp.mx';
        $user->estatus = 'A';
        $user->password = bcrypt('cafeterias2016');
        $user->puntos_reset = Carbon::today();
        $user->save();
        $user->assignRole('admin');

        $user = new User();
        $user->name = 'admin';
        $user->email = 'lacafe.teh@uvp.mx';
        $user->estatus = 'A';
        $user->password = bcrypt('cafeterias2016');
        $user->puntos_reset = Carbon::today();
        $user->save();
        $user->assignRole('admin');

        /*$user = new User();
        $user->name = 'super';
        $user->email = '';
        $user->estatus = 'A';
        $user->password = bcrypt('');
        $user->puntos_reset = Carbon::today();
        $user->save();
        $user->assignRole('super');

        $user = new User();
        $user->name = 'geren';
        $user->email = '';
        $user->estatus = 'A';
        $user->password = bcrypt('');
        $user->puntos_reset = Carbon::today();
        $user->save();
        $user->assignRole('geren');*/

        $user = new User();
        $user->name = 'cajero';
        $user->email = 'gerencia.centro@winkycoffee.com';
        $user->estatus = 'A';
        $user->password = bcrypt('centro1481');
        $user->puntos_reset = Carbon::today();
        $user->save();
        $user->assignRole('cajero');

        $user = new User();
        $user->name = 'cajero';
        $user->email = 'info@uvp.mx';
        $user->estatus = 'A';
        $user->password = bcrypt('info8430');
        $user->puntos_reset = Carbon::today();
        $user->save();
        $user->assignRole('cajero');

        $user = new User();
        $user->name = 'cajero';
        $user->email = 'subgerencia.cafeterias@uvp.mx';
        $user->estatus = 'A';
        $user->password = bcrypt('Will17');
        $user->puntos_reset = Carbon::today();
        $user->save();
        $user->assignRole('cajero');

        $user = new User();
        $user->name = 'cajero';
        $user->email = 'subgerencia.juarez@winkycoffee.com';
        $user->estatus = 'A';
        $user->password = bcrypt('lau2204');
        $user->puntos_reset = Carbon::today();
        $user->save();
        $user->assignRole('cajero');

        $user = new User();
        $user->name = 'cajero';
        $user->email = 'marijosefls.mf@gmail.com';
        $user->estatus = 'A';
        $user->password = bcrypt('marijo123');
        $user->puntos_reset = Carbon::today();
        $user->save();
        $user->assignRole('cajero');

        $user = new User();
        $user->name = 'cajero';
        $user->email = 'loren_mia_16@hotmail.com';
        $user->estatus = 'A';
        $user->password = bcrypt('patito130');
        $user->puntos_reset = Carbon::today();
        $user->save();
        $user->assignRole('cajero');

        $user = new User();
        $user->name = 'cajero';
        $user->email = 'oxin.30@hotmail.com';
        $user->estatus = 'A';
        $user->password = bcrypt('cyntia123');
        $user->puntos_reset = Carbon::today();
        $user->save();
        $user->assignRole('cajero');

        $user = new User();
        $user->name = 'cajero';
        $user->email = 'nicoo_le.xd@hotmail.com';
        $user->estatus = 'A';
        $user->password = bcrypt('yuliana123');
        $user->puntos_reset = Carbon::today();
        $user->save();
        $user->assignRole('cajero');


        ///usuarios deshabilitados

        $user = new User();
        $user->name = 'cajero';
        $user->email = 'administracion@winkycoffe.com';
        $user->estatus = 'B';
        $user->password = bcrypt('laura moreno');
        $user->puntos_reset = Carbon::today();
        $user->save();
        $user->assignRole('cajero');

        $user = new User();
        $user->name = 'cajero';
        $user->email = 'janett032@hotmail.com';
        $user->estatus = 'B';
        $user->password = bcrypt('8526');
        $user->puntos_reset = Carbon::today();
        $user->save();
        $user->assignRole('cajero');

        $user = new User();
        $user->name = 'cajero';
        $user->email = 'andrea.galba@hotmail.com';
        $user->estatus = 'B';
        $user->password = bcrypt('2326');
        $user->puntos_reset = Carbon::today();
        $user->save();
        $user->assignRole('cajero');

        $user = new User();
        $user->name = 'cajero';
        $user->email = 'ara.adn.2345@gmail.com';
        $user->estatus = 'B';
        $user->password = bcrypt('1987');
        $user->puntos_reset = Carbon::today();
        $user->save();
        $user->assignRole('cajero');

        $user = new User();
        $user->name = 'cajero';
        $user->email = 'susengr32@hotmail.com';
        $user->estatus = 'B';
        $user->password = bcrypt('3002');
        $user->puntos_reset = Carbon::today();
        $user->save();
        $user->assignRole('cajero');

        $user = new User();
        $user->name = 'cajero';
        $user->email = 'gerencia.centro2@winkycoffee.com';
        $user->estatus = 'B';
        $user->password = bcrypt('Winkycentro');
        $user->puntos_reset = Carbon::today();
        $user->save();
        $user->assignRole('cajero');

        $user = new User();
        $user->name = 'cajero';
        $user->email = 'gtjuan@outlook.es';
        $user->estatus = 'B';
        $user->password = bcrypt('juan');
        $user->puntos_reset = Carbon::today();
        $user->save();
        $user->assignRole('cajero');

        $user = new User();
        $user->name = 'cajero';
        $user->email = 'darckangel22sailor@gmail.com';
        $user->estatus = 'B';
        $user->password = bcrypt('1234');
        $user->puntos_reset = Carbon::today();
        $user->save();
        $user->assignRole('cajero');


    }
}
