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
        Material::create(['name'=>'Estucado semimate' ,'familia'=>'']);
        Material::create(['name'=>'Estucado mate' ,'familia'=>'']);
        Material::create(['name'=>'Estucado brillo' ,'familia'=>'']);
        Material::create(['name'=>'Offset' ,'familia'=>'INT']);
        Material::create(['name'=>'Holmen' ,'familia'=>'INT']);
        Material::create(['name'=>'Munken' ,'familia'=>'INT']);
        Material::create(['name'=>'Caña de azucar' ,'familia'=>'']);

        Material::create(['name'=>'Folding' ,'familia'=>'CUB']);
        Material::create(['name'=>'Cartulina gráfica' ,'familia'=>'CUB']);
        Material::create(['name'=>'Cartón' ,'familia'=>'CUB']);

    }
}
