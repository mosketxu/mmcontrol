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
        Encuadernacion::create(['name'=>'PUR']);
        Encuadernacion::create(['name'=>'Grapado']);
        Encuadernacion::create(['name'=>'Flexibook']);
        Encuadernacion::create(['name'=>'Cartoné']);
        Encuadernacion::create(['name'=>'Cartoné cosido']);
        Encuadernacion::create(['name'=>'Espiral']);
        Encuadernacion::create(['name'=>'Wire-o']);
        Encuadernacion::create(['name'=>'Rustica PUR']);
        Encuadernacion::create(['name'=>'Rustica cosida']);
        Encuadernacion::create(['name'=>'Hendido y grapa']);
        Encuadernacion::create(['name'=>'Plegado']);
        Encuadernacion::create(['name'=>'Wiro']);
    }
}
