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
            'pedido_id'=>'220001',
            'producto_id'=>'2',
            'tirada'=>'5',
            'precio_ud'=>'10',
            'preciototal'=>'50',
            ]);
    }
}
