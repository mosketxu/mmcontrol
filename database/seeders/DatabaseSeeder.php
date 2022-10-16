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
        // $this->call(UsersTableSeeder::class);
        // $this->call(RoleSeeder::class);
        // $this->call(PaisesTableSeeder::class);
        // $this->call(ProvinciasTableSeeder::class);
        // $this->call(MetodoPagoSeeder::class);
        // $this->call(EntidadTipoSeeder::class);

        $this->call(PermissionSeeder::class);

       // $this->call(UbicacionesSeeder::class);
       // $this->call(UnidadSeeder::class);
       // $this->call(SolicitantesTableSeeder::class);
       // $this->call(EntidadesTableSeeder::class);
       // $this->call(ProductoTipoSeeder::class);
       // $this->call(ProductoMaterialesSeeder::class);
       // $this->call(ProductoAcabadoSeeder::class);
       // $this->call(UnidadCosteSeeder::class);
       // $this->call(ProductoGrupoproduccionSeeder::class);
       // $this->call(ProductoFamiliaSeeder::class);
       // $this->call(ProductoCajaSeeder::class);
       // $this->call(ProductosTableSeeder::class);
       // $this->call(AccionTipoSeeder::class);
       // $this->call(AccionesTableSeeder::class);
       // $this->call(EmpresaTipoSeeder::class);
    }
}
