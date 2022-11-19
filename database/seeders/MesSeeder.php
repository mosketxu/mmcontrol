<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('meses')->delete();

        \DB::table('meses')->insert(array (
            0 => array ('id' => '1', 'mesminus'=>'enero','mesmayus'=>'Enero','mes3'=>'ene','mes2' => '01'),
            1 => array ('id' => '2', 'mesminus'=>'febrero','mesmayus'=>'Febrero','mes3'=>'feb','mes2' => '02'),
            2 => array ('id' => '3', 'mesminus'=>'marzo','mesmayus'=>'Marzo','mes3'=>'mar','mes2' => '03'),
            3 => array ('id' => '4', 'mesminus'=>'abril','mesmayus'=>'Abril','mes3'=>'abr','mes2' => '04'),
            4 => array ('id' => '5', 'mesminus'=>'mayo','mesmayus'=>'Mayo','mes3'=>'may','mes2' => '05'),
            5 => array ('id' => '6', 'mesminus'=>'junio','mesmayus'=>'Junio','mes3'=>'jun','mes2' => '06'),
            6 => array ('id' => '7', 'mesminus'=>'julio','mesmayus'=>'Julio','mes3'=>'jul','mes2' => '07'),
            8 => array ('id' => '8', 'mesminus'=>'agosto','mesmayus'=>'Agosto','mes3'=>'ago','mes2' => '08'),
            9 => array ('id' => '9', 'mesminus'=>'septiembre','mesmayus'=>'Septiembre','mes3'=>'sep','mes2' => '09'),
            10 => array ('id' => '10','mesminus'=>'octubre','mesmayus'=>'Octubre','mes3'=>'oct','mes2' => '10'),
            11 => array ('id' => '11','mesminus'=>'noviembre','mesmayus'=>'Noviembre','mes3'=>'nov','mes2' => '11'),
            12 => array ('id' => '12','mesminus'=>'diciembre','mesmayus'=>'Diciembre','mes3'=>'dic','mes2' => '12'),
        ));
    }
}
