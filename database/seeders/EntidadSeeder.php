<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Entidad;

class EntidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Entidad::create(['entidad'=>'Algamar']);
        Entidad::create(['entidad'=>'Alsina']);
        Entidad::create(['entidad'=>'Arvato']);
        Entidad::create(['entidad'=>'Beauty Cluster']);
        Entidad::create(['entidad'=>'BJC']);
        Entidad::create(['entidad'=>'Casgràfic']);
        Entidad::create(['entidad'=>'Claudia & Julia']);
        Entidad::create(['entidad'=>'Dermofarm']);
        Entidad::create(['entidad'=>'Difusión']);
        Entidad::create(['entidad'=>'Difusión Klett USA']);
        Entidad::create(['entidad'=>'Dopigraf']);
        Entidad::create(['entidad'=>'EMDL']);
        Entidad::create(['entidad'=>'EMS']);
        Entidad::create(['entidad'=>'Fira Girona']);
        Entidad::create(['entidad'=>'Fluvitex']);
        Entidad::create(['entidad'=>'G. Relojería']);
        Entidad::create(['entidad'=>'Koolair']);
        Entidad::create(['entidad'=>'La Caixa']);
        Entidad::create(['entidad'=>'Le creusset']);
        Entidad::create(['entidad'=>'Libelista']);
        Entidad::create(['entidad'=>'Llibres Parcir']);
        Entidad::create(['entidad'=>'Loftur Studio S.L.']);
        Entidad::create(['entidad'=>'Montellano']);
        Entidad::create(['entidad'=>'Nadal']);
        Entidad::create(['entidad'=>'Proclínic']);
        Entidad::create(['entidad'=>'Quaderna E.C.']);
        Entidad::create(['entidad'=>'Talenland']);
        Entidad::create(['entidad'=>'Teresita D']);
        Entidad::create(['entidad'=>'Tous Watches']);
        Entidad::create(['entidad'=>'Velamen']);
        Entidad::create(['entidad'=>'Viu San Feliu']);
    }
}
