<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EntidadTipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('entidad_tipos')->delete();

        \DB::table('entidad_tipos')->insert(array (
            0 =>array ('id' => 0,'nombre' => 'Contacto','nombrecorto' => 'CON','nombreplural'=>'Entidades'),
            1 =>array ('id' => 1,'nombre' => 'Cliente','nombrecorto' => 'CLI','nombreplural'=>'Clientes'),
            2 =>array ('id' => 3,'nombre' => 'Cliente-Proveedor','nombrecorto' => 'C-P','nombreplural'=>'Clientes/Proveedores'),
            3 =>array ('id' => 2,'nombre' => 'Proveedor','nombrecorto' => 'PRO','nombreplural'=>'Proveedores'),
            4 =>array ('id' => 3,'nombre' => 'Prospección','nombrecorto' => 'PRP','nombreplural'=>'Prospecciones'),
        ));
    }
}
