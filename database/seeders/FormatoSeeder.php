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
        \DB::table('formatos')->delete();

        Formato::create(['name'=>'130x180']);
        Formato::create(['name'=>'134x190']);
        Formato::create(['name'=>'135x190']);
        Formato::create(['name'=>'145x195']);
        Formato::create(['name'=>'150x210']);
        Formato::create(['name'=>'150x230']);
        Formato::create(['name'=>'170x240']);
        Formato::create(['name'=>'195x276']);
        Formato::create(['name'=>'205x280']);
        Formato::create(['name'=>'209x257']);
        Formato::create(['name'=>'210x260']);
        Formato::create(['name'=>'210x270']);
        Formato::create(['name'=>'210X280']);
        Formato::create(['name'=>'210x297']);
        Formato::create(['name'=>'220x2305']);
        Formato::create(['name'=>'220x270']);
        Formato::create(['name'=>'220x305']);
        Formato::create(['name'=>'240x287']);
        Formato::create(['name'=>'245x175']);
        Formato::create(['name'=>'245x275']);
        Formato::create(['name'=>'249x297']);
        Formato::create(['name'=>'250x270']);
        Formato::create(['name'=>'250x297']);
        Formato::create(['name'=>'255x245']);
        Formato::create(['name'=>'270x225']);
        Formato::create(['name'=>'80x80']);
        Formato::create(['name'=>'82x82']);
        Formato::create(['name'=>'98x109']);
    }
}
