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
            'id'=>'1',
            'cliente_id'=>'2',
            'contacto_id'=>'1',
            'tipo'=>'1',
            'fecha'=>'2022-01-01',
            'producto_id'=>'1',
            'referencia'=>'referencia de la oferta',
            'formato'=>'200 x 200',
            'extension'=>'46',
            'interiorcomposicion'=>'offset 250',
            'interiorimpresion'=>'4+4',
            'cubiertacomposicion'=>'carton',
            'cubiertaimpresion'=>'4+0',
            'guardascomposicion'=>'sin guardas',
            'guardasimpresion'=>'0+0',
            'acabado'=>'PUR',
            'manipulacion'=>'sin manipulacion',
            'entrega'=>'en varios puntos',
            'observaciones'=>'muchas pero no las pongo',
            'estado'=>'0',
            ]);
     }
}
