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
        // \App\Models\User::factory(10)->create();
        $this->call(RoleSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(PaisesTableSeeder::class);
        $this->call(ProvinciasTableSeeder::class);
        $this->call(MetodoPagoSeeder::class);
        $this->call(EntidadSeeder::class);
        $this->call(EntidadTipoSeeder::class);

        $this->call(PermissionSeeder::class);

        $this->call(CajaSeeder::class);
        $this->call(FormatoSeeder::class);
        $this->call(EncuadernacionSeeder::class);
        $this->call(GramajeSeeder::class);
        $this->call(MaterialSeeder::class);
        $this->call(PlastificadoSeeder::class);
        $this->call(TintaSeeder::class);
        $this->call(ProductoSeeder::class);
        $this->call(PedidoSeeder::class);

    }
}
