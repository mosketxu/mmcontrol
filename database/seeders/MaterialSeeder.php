<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('materiales')->delete();

        Material::create(['name'=>'Caña azucar' ,'familia'=>'']);
        Material::create(['name'=>'Estucado' ,'familia'=>'']);
        Material::create(['name'=>'Estucado + Offset' ,'familia'=>'']);
        Material::create(['name'=>'Estucado Brillo' ,'familia'=>'']);
        Material::create(['name'=>'Estucado Mate' ,'familia'=>'']);
        Material::create(['name'=>'Estucado Semimate' ,'familia'=>'']);
        Material::create(['name'=>'Holmen' ,'familia'=>'INT']);
        Material::create(['name'=>'Munken' ,'familia'=>'INT']);
        Material::create(['name'=>'Offset' ,'familia'=>'INT']);
        Material::create(['name'=>'Offset + Estucado Semimate' ,'familia'=>'INT']);
        Material::create(['name'=>'Offset Blanco' ,'familia'=>'INT']);
        Material::create(['name'=>'Folding' ,'familia'=>'CUB']);
        Material::create(['name'=>'Cartulina gráfica' ,'familia'=>'CUB']);
        Material::create(['name'=>'Cartón' ,'familia'=>'CUB']);

    }
}
