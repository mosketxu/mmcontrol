<?php

namespace Database\Seeders;

use App\Models\Plastificado;
use Illuminate\Database\Seeder;

class PlastificadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \DB::table('plastificados')->delete();

        Plastificado::create(['name'=>'PPB 1C']);
        Plastificado::create(['name'=>'PPM 1C']);
        Plastificado::create(['name'=>'PPM 2C']);
        Plastificado::create(['name'=>'PPB 2C']);
        Plastificado::create(['name'=>'PPM Antirayas 1C']);
        Plastificado::create(['name'=>'PPM Soft touch 1C']);
        Plastificado::create(['name'=>'lacado acrílico']);
    }
}
