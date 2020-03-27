<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CiudadTableSeeder::class);
        $this->call(EmpresaTableSeeder::class);
        $this->call(RolTableSeeder::class);
        $this->call(ClasificacionTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(TipoPerfilTableSeeder::class);
        $this->call(PerfilTableSeeder::class);
        //$this->call(TipoPromocionTableSeeder::class);
        //$this->call(PromocionTableSeeder::class);
        //$this->call(ParticipanteTableSeeder::class);
        //$this->call(PremioTableSeeder::class);
        //$this->call(TransaccionesTableSeeder::class);
        $this->call(TipoBonoTableSeeder::class);
        $this->call(TiempoTableSeeder::class);
        //$this->call(BonoTableSeeder::class);
        //$this->call(BonoDetalleTableSeeder::class);
    }
}
