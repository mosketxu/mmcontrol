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
            'contacto_id'=>'47',
            'oferta_id'=>'1508',
            'pedidocliente'=>'3580a',
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
        Pedido::create([
            'tipo'=>'1',
            'id'=>'2200002',
            'tipo'=>'1',
            'responsable'=>'Pedro',
            'cliente_id'=>'2',
            'facturadopor_id'=>'1',
            'contacto_id'=>'47',
            'oferta_id'=>'40abc',
            'pedidocliente'=>'bb80a',
            'producto_id'=>'2',
            'fechapedido'=>'2022-11-10',
            'fechaarchivos'=>'2022-11-15',
            'fechaplotter'=>'2022-11-20',
            'fechaentrega'=>'2022-11-30',
            'tiradaprevista'=>'100',
            'tiradareal'=>'120',
            'precio'=>'48',
            'preciototal'=>'4800',
            'muestra'=>'una de cada',
            'pruebacolor'=>'ferro',
            'estado'=>'0',
            'uds_caja'=>'12',
            ]);
        Pedido::create([
            'tipo'=>'1',
            'id'=>'2200003',
            'tipo'=>'1',
            'responsable'=>'Alex',
            'cliente_id'=>'2',
            'facturadopor_id'=>'1',
            'contacto_id'=>'48',
            'oferta_id'=>'40000',
            'pedidocliente'=>'bb80a',
            'producto_id'=>'2',
            'fechapedido'=>'2022-12-10',
            'fechaarchivos'=>'2022-12-15',
            'fechaplotter'=>'2022-12-20',
            'fechaentrega'=>'2022-12-30',
            'tiradaprevista'=>'57',
            'tiradareal'=>'58',
            'precio'=>'10',
            'preciototal'=>'570',
            'muestra'=>'dos de cada',
            'pruebacolor'=>'ferro y croma',
            'estado'=>'0',
            'uds_caja'=>'7',
            ]);
     }
}
