<?php

namespace Database\Seeders;

use App\Models\Formato;
use Illuminate\Database\Seeder;

class FormatoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Formato::create(['name'=>'210x280']);
        Formato::create(['name'=>'210x297']);
        Formato::create(['name'=>'220x270']);
        Formato::create(['name'=>'220x305']);
        Formato::create(['name'=>'240x287']);
        Formato::create(['name'=>'250x270']);
        Formato::create(['name'=>'250x297']);
        Formato::create(['name'=>'148x210']);
        Formato::create(['name'=>'270x225']);

    }
}
