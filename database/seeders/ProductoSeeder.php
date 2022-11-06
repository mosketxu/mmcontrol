<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('productos')->delete();

        Producto::create([
            'tipo'=>'1',
            'cliente_id'=>'1',
            'isbn'=>'123456',
            'referencia'=>'Libro prueba',
            'preciocoste'=>'45',
            'precioventa'=>'50',
            'tirada'=>'500',
            'formato'=>'210x280',
            'FSC'=>true,
            'materialinterior'=>'Estucado mate',
            'tintainterior'=>'4+4',
            'gramajeinterior'=>'100',
            'materialcubierta'=>'Cartulina gráfica',
            'tintacubierta'=>'4+1',
            'gramajecubierta'=>'250',
            'paginas'=>'300',
            'plastificado'=>'PPB 2C',
            'encuadernado'=>'Pur',
            'solapa'=>true,
            'descripsolapa'=>'Solapa prueba',
            'guardas'=>true,
            'descripguardas'=>'Guardas prueba',
            'cd'=>true,
            'descripcd'=>'CD prueba',
            'novedad'=>true,
            'descripnovedad'=>'Novedad prueba',
            'caja'=>true,
            'udxcaja'=>'8',
            'especiflogistica'=>'Especificacion prueba',
            'observaciones'=>'Observaciones prueba',
        ]);
        Producto::create([
            'tipo'=>'1',
            'cliente_id'=>'2',
            'isbn'=>'78910',
            'referencia'=>'Otro Libro prueba',
            'preciocoste'=>'245',
            'precioventa'=>'350',
            'tirada'=>'2500',
            'formato'=>'210x297',
            'FSC'=>true,
            'materialinterior'=>'Estucado brillo',
            'tintainterior'=>'4+4',
            'gramajeinterior'=>'90',
            'materialcubierta'=>'Cartón',
            'tintacubierta'=>'4+0',
            'gramajecubierta'=>'2,5mm',
            'paginas'=>'450',
            'plastificado'=>'PPM 2C',
            'encuadernado'=>'Rustica cosida',
            'solapa'=>true,
            'descripsolapa'=>'Solapa prueba 2',
            'guardas'=>true,
            'descripguardas'=>'Guardas prueba 2',
            'cd'=>true,
            'descripcd'=>'CD prueba 2',
            'novedad'=>true,
            'descripnovedad'=>'Novedad prueba 2',
            'caja'=>true,
            'udxcaja'=>'3',
            'especiflogistica'=>'Especificacion prueba 2',
            'observaciones'=>'Observaciones prueba 2',
        ]);

    }
}
