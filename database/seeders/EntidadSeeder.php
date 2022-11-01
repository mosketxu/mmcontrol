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
        \DB::table('entidades')->delete();

        Entidad::create(['entidad'=>'Algamar','entidadtipo_id'=>'1']);
        Entidad::create(['entidad'=>'Alsina','entidadtipo_id'=>'1']);
        Entidad::create(['entidad'=>'Arvato','entidadtipo_id'=>'1']);
        Entidad::create(['entidad'=>'Beauty Cluster','entidadtipo_id'=>'1']);
        Entidad::create(['entidad'=>'BJC','entidadtipo_id'=>'1']);
        Entidad::create(['entidad'=>'Casgràfic','entidadtipo_id'=>'1']);
        Entidad::create(['entidad'=>'Claudia & Julia','entidadtipo_id'=>'1']);
        Entidad::create(['entidad'=>'Dermofarm','entidadtipo_id'=>'1']);
        Entidad::create(['entidad'=>'Difusión','entidadtipo_id'=>'1']);
        Entidad::create(['entidad'=>'Difusión Klett USA','entidadtipo_id'=>'1']);
        Entidad::create(['entidad'=>'Dopigraf','entidadtipo_id'=>'2']);
        Entidad::create(['entidad'=>'EMDL','entidadtipo_id'=>'1']);
        Entidad::create(['entidad'=>'EMS','entidadtipo_id'=>'2']);
        Entidad::create(['entidad'=>'Fira Girona','entidadtipo_id'=>'1']);
        Entidad::create(['entidad'=>'Fluvitex','entidadtipo_id'=>'1']);
        Entidad::create(['entidad'=>'G. Relojería','entidadtipo_id'=>'1']);
        Entidad::create(['entidad'=>'Koolair','entidadtipo_id'=>'1']);
        Entidad::create(['entidad'=>'La Caixa','entidadtipo_id'=>'1']);
        Entidad::create(['entidad'=>'Le creusset','entidadtipo_id'=>'1']);
        Entidad::create(['entidad'=>'Libelista','entidadtipo_id'=>'1']);
        Entidad::create(['entidad'=>'Llibres Parcir','entidadtipo_id'=>'1']);
        Entidad::create(['entidad'=>'Loftur Studio S.L.','entidadtipo_id'=>'1']);
        Entidad::create(['entidad'=>'Montellano','entidadtipo_id'=>'1']);
        Entidad::create(['entidad'=>'Nadal','entidadtipo_id'=>'1']);
        Entidad::create(['entidad'=>'Proclínic','entidadtipo_id'=>'1']);
        Entidad::create(['entidad'=>'Quaderna E.C.','entidadtipo_id'=>'1']);
        Entidad::create(['entidad'=>'Talenland','entidadtipo_id'=>'1']);
        Entidad::create(['entidad'=>'Teresita D','entidadtipo_id'=>'1']);
        Entidad::create(['entidad'=>'Tous Watches','entidadtipo_id'=>'1']);
        Entidad::create(['entidad'=>'Velamen','entidadtipo_id'=>'1']);
        Entidad::create(['entidad'=>'Viu San Feliu','entidadtipo_id'=>'1']);
        Entidad::create(['entidad'=>'Novoprint','entidadtipo_id'=>'3']);
        Entidad::create(['entidad'=>'Mundo','entidadtipo_id'=>'3']);
        Entidad::create(['entidad'=>'Gómez Aparcio','entidadtipo_id'=>'3']);
        Entidad::create(['entidad'=>'Liberdigital','entidadtipo_id'=>'3']);
        Entidad::create(['entidad'=>'Prodigitalk','entidadtipo_id'=>'3']);
        Entidad::create(['entidad'=>'Tórculo','entidadtipo_id'=>'3']);
        Entidad::create(['entidad'=>'Maset','entidadtipo_id'=>'3']);
        Entidad::create(['entidad'=>'DS Smith','entidadtipo_id'=>'3']);
        Entidad::create(['entidad'=>'Triple Q','entidadtipo_id'=>'3']);
        Entidad::create(['entidad'=>'Comgràfic','entidadtipo_id'=>'3']);
        Entidad::create(['entidad'=>'Grafitex','entidadtipo_id'=>'3']);
        Entidad::create(['entidad'=>'Labporta','entidadtipo_id'=>'3']);
        Entidad::create(['entidad'=>'Jomagar plano','entidadtipo_id'=>'3']);
        Entidad::create(['entidad'=>'Jomagar rotativa','entidadtipo_id'=>'3']);

    }
}
