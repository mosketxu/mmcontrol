<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Encuadernacion;

class EncuadernacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('encuadernaciones')->delete();

        Encuadernacion::create(['name'=>'Cosido']);
        Encuadernacion::create(['name'=>'Pur']);
        Encuadernacion::create(['name'=>'Grapado']);
        Encuadernacion::create(['name'=>'Flexibook']);
        Encuadernacion::create(['name'=>'Cartoné']);
        Encuadernacion::create(['name'=>'Espiral']);
        Encuadernacion::create(['name'=>'Wire-o']);
        Encuadernacion::create(['name'=>'Rustica PUR']);
        Encuadernacion::create(['name'=>'Rustica cosida']);
    }
}
