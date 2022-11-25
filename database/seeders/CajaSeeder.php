<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Caja;

class CajaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('cajas')->delete();

        Caja::create(['name'=>'EMDL']);
        Caja::create(['name'=>'TALENLAND']);
        Caja::create(['name'=>'KLETT USA']);
        Caja::create(['name'=>'DIFUSIÓN']);
        Caja::create(['name'=>'Anónima de doble canal']);
        Caja::create(['name'=>'Directament sobre palet']);
        Caja::create(['name'=>'Cajas neutras']);
    }
}
