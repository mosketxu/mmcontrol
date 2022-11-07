<?php

namespace Database\Seeders;

use App\Models\Pedido;
use Illuminate\Database\Seeder;

class PedidoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('pedidos')->delete();

        Pedido::create([
            'tipo'=>'1',
            'id'=>'2200001',
            'tipo'=>'1',
            'responsable'=>'Alex',
            'cliente_id'=>'2',
            'facturadopor_id'=>'1',
            'producto_id'=>'1',
            'fechapedido'=>'2022-11-06',
            'fechaarchivos'=>'2022-11-06',
            'fechaplotter'=>'2022-11-06',
            'fechaentrega'=>'2022-11-06',
            'tiradaprevista'=>'500',
            'tiradareal'=>'500',
            'precio'=>'500',
            'preciototal'=>'500',
            'muestra'=>'solo una',
            'pruebacolor'=>'cromalin',
            'estado'=>'0',
            'uds_caja'=>'8',
            ]);
     }
}
