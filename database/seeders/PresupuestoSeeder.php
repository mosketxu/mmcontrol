<?php

namespace Database\Seeders;

use App\Models\Presupuesto;
use Illuminate\Database\Seeder;

class PresupuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('presupuestos')->delete();

        Presupuesto::create([
            'tipo'=>'1',
            'id'=>'2200001',
            'tipo'=>'1',
            'responsable'=>'Alex',
            'cliente_id'=>'2',
            'contacto_id'=>'47',
            'proveedor_id'=>'40',
            'facturadopor_id'=>'1',
            'fechapresupuesto'=>'2022-11-06',
            'tirada'=>'500',
            'precio_ud'=>'10',
            'preciototal'=>'5000',
            'espedido'=>'0',
            'estado'=>'0',
            'uds_caja'=>'8',
            'otros'=>'Sin comentarios',
            ]);
            Presupuesto::create([
            'tipo'=>'1',
            'id'=>'2200002',
            'tipo'=>'1',
            'responsable'=>'Pedro',
            'cliente_id'=>'2',
            'contacto_id'=>'47',
            'proveedor_id'=>'40',
            'facturadopor_id'=>'1',
            'fechapresupuesto'=>'2022-11-06',
            'tirada'=>'500',
            'precio_ud'=>'10',
            'preciototal'=>'5000',
            'espedido'=>'1',
            'estado'=>'0',
            'uds_caja'=>'8',
            'otros'=>'Sin comentarios',
            'uds_caja'=>'12',
            ]);
        }
}
