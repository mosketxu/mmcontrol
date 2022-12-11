<?php

namespace Database\Seeders;

use App\Models\PresupuestoProducto;
use Illuminate\Database\Seeder;

class PresupuestoProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \DB::table('presupuesto_productos')->delete();

        PresupuestoProducto::create([
            'presupuesto_id'=>'2200001',
            'producto_id'=>'2',
            'tirada'=>'5',
            'precio_ud'=>'10',
            'preciototal'=>'50',
            ]);
        PresupuestoProducto::create([
            'presupuesto_id'=>'2200002',
            'producto_id'=>'1',
            'tirada'=>'5',
            'precio_ud'=>'10',
            'preciototal'=>'50',
            ]);
    }
}
