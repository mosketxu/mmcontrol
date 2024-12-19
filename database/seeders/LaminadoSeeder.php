<?php

namespace Database\Seeders;

use App\Models\Laminado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LaminadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('laminados')->delete();

        Laminado::create(['id'=>1,'name'=>'No' ,'descripcion'=>'No lleva laminado']);
        Laminado::create(['id'=>2,'name'=>'Naturflex' ,'descripcion'=>'Laminado Naturflex']);
        Laminado::create(['id'=>3,'name'=>'Plástico' ,'descripcion'=>'Laminado plástico']);
    }
}
