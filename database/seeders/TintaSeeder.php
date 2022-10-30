<?php

namespace Database\Seeders;

use App\Models\Tinta;
use Illuminate\Database\Seeder;

class TintaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tinta::create(['name'=>'4+4' ,'familia'=>'']);
        Tinta::create(['name'=>'2+2' ,'familia'=>'']);
        Tinta::create(['name'=>'1+1' ,'familia'=>'']);
        Tinta::create(['name'=>'4+4/2+2' ,'familia'=>'INT']);
        Tinta::create(['name'=>'4+0' ,'familia'=>'CUB']);
        Tinta::create(['name'=>'2+0' ,'familia'=>'CUB']);
        Tinta::create(['name'=>'1+0' ,'familia'=>'CUB']);
        Tinta::create(['name'=>'4+1' ,'familia'=>'CUB']);

    }
}
