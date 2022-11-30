<?php

namespace Database\Seeders;

use App\Models\Oferta;
use Illuminate\Database\Seeder;


class OfertaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('ofertas')->delete();

        Oferta::create([
            'id'=>'2200001',
            'cliente_id'=>'2',
            'contacto_id'=>'1',
            'tipo'=>'1',
            'fecha'=>'2022-01-01',
            'producto_id'=>'1',
            'descripcion'=>'descripción de la oferta',
            'entrega'=>'en varios puntos',
            'observaciones'=>'muchas pero no las pongo',
            'estado'=>'0',
            ]);
     }
}
