<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IdiomaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('idiomas')->insert([
            ['codigo' => 'ES', 'nombre' => 'Español'],
            ['codigo' => 'EN', 'nombre' => 'Inglés'],
        ]);
    }
}
