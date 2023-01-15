<?php

namespace Database\Seeders;

use App\Models\Responsable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;



class ResponsablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('responsables')->delete();

        Responsable::create(['responsable' => 'Josep Maria']);
        Responsable::create(['responsable' => 'Marta']);
        Responsable::create(['responsable' => 'Anna']);
        Responsable::create(['responsable' => 'Elisabet']);
    }
}
