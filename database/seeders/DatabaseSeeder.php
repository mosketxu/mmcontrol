<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(PaisesTableSeeder::class);
        $this->call(MesSeeder::class);
        $this->call(ProvinciasTableSeeder::class);
        $this->call(MetodoPagoSeeder::class);
        $this->call(EntidadSeeder::class);
        $this->call(EntidadTipoSeeder::class);
        $this->call(EntidadContactoSeeder::class);


        $this->call(CajaSeeder::class);
        $this->call(FormatoSeeder::class);
        $this->call(EncuadernacionSeeder::class);
        $this->call(GramajeSeeder::class);
        $this->call(MaterialSeeder::class);
        $this->call(PlastificadoSeeder::class);
        $this->call(TintaSeeder::class);
        $this->call(ProductoSeeder::class);
        $this->call(PresupuestoSeeder::class);
        $this->call(PresupuestoProductoSeeder::class);
        $this->call(PedidoSeeder::class);
        $this->call(PedidoProductoSeeder::class);
        $this->call(OfertaSeeder::class);

    }
}
