<?php

namespace Database\Seeders;

use App\Models\Gramaje;
use Illuminate\Database\Seeder;

class GramajeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('gramajes')->delete();

        Gramaje::create(['name'=>'60' ,'familia'=>'INT']);
        Gramaje::create(['name'=>'70' ,'familia'=>'INT']);
        Gramaje::create(['name'=>'80' ,'familia'=>'INT']);
        Gramaje::create(['name'=>'90' ,'familia'=>'INT']);
        Gramaje::create(['name'=>'90+90' ,'familia'=>'']);
        Gramaje::create(['name'=>'100','familia'=>'INT']);
        Gramaje::create(['name'=>'115','familia'=>'']);
        Gramaje::create(['name'=>'120','familia'=>'']);
        Gramaje::create(['name'=>'130','familia'=>'']);
        Gramaje::create(['name'=>'135','familia'=>'']);
        Gramaje::create(['name'=>'140','familia'=>'']);
        Gramaje::create(['name'=>'150','familia'=>'']);
        Gramaje::create(['name'=>'160','familia'=>'']);
        Gramaje::create(['name'=>'170','familia'=>'']);
        Gramaje::create(['name'=>'200','familia'=>'']);
        Gramaje::create(['name'=>'225','familia'=>'CUB']);
        Gramaje::create(['name'=>'240','familia'=>'CUB']);
        Gramaje::create(['name'=>'240 2C','familia'=>'CUB']);
        Gramaje::create(['name'=>'241 2C','familia'=>'CUB']);
        Gramaje::create(['name'=>'250 2C','familia'=>'CUB']);
        Gramaje::create(['name'=>'245','familia'=>'CUB']);
        Gramaje::create(['name'=>'250','familia'=>'CUB']);
        Gramaje::create(['name'=>'263','familia'=>'CUB']);
        Gramaje::create(['name'=>'296','familia'=>'']);
        Gramaje::create(['name'=>'300','familia'=>'CUB']);
        Gramaje::create(['name'=>'350','familia'=>'CUB']);
        Gramaje::create(['name'=>'380','familia'=>'CUB']);
        Gramaje::create(['name'=>'2mm','familia'=>'CUB']);
        Gramaje::create(['name'=>'2,5mm','familia'=>'CUB']);
    }
}
