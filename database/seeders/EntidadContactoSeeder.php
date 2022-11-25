<?php

namespace Database\Seeders;

use App\Models\EntidadContacto;
use Illuminate\Database\Seeder;

class EntidadContactoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \DB::table('entidad_contactos')->delete();

        EntidadContacto::create([
            'entidad_id'=>'2',
            'contacto_id'=>'47',
            'departamento'=>'1',
            'comentarios'=>'Alex',
            ]);
        EntidadContacto::create([
            'entidad_id'=>'2',
            'contacto_id'=>'48',
            'departamento'=>'Marketing',
            'comentarios'=>'varios',
            ]);
    }
}
