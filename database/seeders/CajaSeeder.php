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

        Caja::create(['id'=>'1','name'=>'EMDL']);
        Caja::create(['id'=>'2','name'=>'TALENLAND']);
        Caja::create(['id'=>'3','name'=>'KLETT USA']);
        Caja::create(['id'=>'4','name'=>'DIFUSIÓN']);
        Caja::create(['id'=>'5','name'=>'Anónima de doble canal']);
        Caja::create(['id'=>'6','name'=>'Directament sobre palet']);
        Caja::create(['id'=>'7','name'=>'Cajas neutras']);
        Caja::create(['id'=>'8','name'=>'USA']);
    }
}
