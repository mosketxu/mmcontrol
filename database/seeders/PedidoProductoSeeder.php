<?php

namespace Database\Seeders;

use App\Models\PedidoProducto;
use Illuminate\Database\Seeder;

class PedidoProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('pedido_productos')->delete();

        PedidoProducto::create([
            'pedido_id'=>'2200001',
            'producto_id'=>'2',
            'tirada'=>'5',
            'precio_ud'=>'10',
            'preciototal'=>'50',
            ]);
        PedidoProducto::create([
            'pedido_id'=>'2200002',
            'producto_id'=>'1',
            'tirada'=>'5',
            'precio_ud'=>'10',
            'preciototal'=>'50',
            ]);
        PedidoProducto::create([
            'pedido_id'=>'2200003',
            'producto_id'=>'2',
            'tirada'=>'5',
            'precio_ud'=>'10',
            'preciototal'=>'50',
            ]);

    }
}
