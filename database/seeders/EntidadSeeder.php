<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Entidad;
use Illuminate\Support\Facades\Schema;

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

        Entidad::create(['id'=>'1','entidad'=>'Milimétrica','entidadtipo_id'=>'3','nif'=>'B63941835']);
        Entidad::create(['id'=>'2','entidad'=>'Algamar','entidadtipo_id'=>'1','responsable'=>'Josep Maria']);
        Entidad::create(['id'=>'3','entidad'=>'Alsina','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'4','entidad'=>'Arvato','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'5','entidad'=>'Beauty Cluster','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'6','entidad'=>'BJC','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'7','entidad'=>'Casgràfic','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'8','entidad'=>'Claudia & Julia','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'9','entidad'=>'Dermofarm','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'10','entidad'=>'Difusión','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'11','entidad'=>'Difusión Klett USA','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'12','entidad'=>'Dopigraf','entidadtipo_id'=>'2']);
        Entidad::create(['id'=>'13','entidad'=>'EMDL','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'14','entidad'=>'EMS','entidadtipo_id'=>'2']);
        Entidad::create(['id'=>'15','entidad'=>'Fira Girona','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'16','entidad'=>'Fluvitex','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'17','entidad'=>'G. Relojería','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'18','entidad'=>'Koolair','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'19','entidad'=>'La Caixa','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'20','entidad'=>'Le creusset','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'21','entidad'=>'Libelista','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'22','entidad'=>'Llibres Parcir','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'23','entidad'=>'Loftur Studio S.L.','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'24','entidad'=>'Montellano','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'25','entidad'=>'Nadal','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'26','entidad'=>'Proclínic','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'27','entidad'=>'Quaderna E.C.','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'28','entidad'=>'Talenland','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'29','entidad'=>'Teresita D','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'30','entidad'=>'Tous Watches','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'31','entidad'=>'Velamen','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'32','entidad'=>'Viu San Feliu','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'33','entidad'=>'Novoprint','entidadtipo_id'=>'3']);
        Entidad::create(['id'=>'34','entidad'=>'Mundo','entidadtipo_id'=>'3']);
        Entidad::create(['id'=>'35','entidad'=>'Gómez Aparcio','entidadtipo_id'=>'3']);
        Entidad::create(['id'=>'36','entidad'=>'Liberdigital','entidadtipo_id'=>'3']);
        Entidad::create(['id'=>'37','entidad'=>'Prodigitalk','entidadtipo_id'=>'3']);
        Entidad::create(['id'=>'38','entidad'=>'Tórculo','entidadtipo_id'=>'3']);
        Entidad::create(['id'=>'39','entidad'=>'Maset','entidadtipo_id'=>'3']);
        Entidad::create(['id'=>'40','entidad'=>'DS Smith','entidadtipo_id'=>'3']);
        Entidad::create(['id'=>'41','entidad'=>'Triple Q','entidadtipo_id'=>'3']);
        Entidad::create(['id'=>'42','entidad'=>'Comgràfic','entidadtipo_id'=>'3']);
        Entidad::create(['id'=>'43','entidad'=>'Grafitex','entidadtipo_id'=>'3']);
        Entidad::create(['id'=>'44','entidad'=>'Labporta','entidadtipo_id'=>'3']);
        Entidad::create(['id'=>'45','entidad'=>'Jomagar plano','entidadtipo_id'=>'3']);
        Entidad::create(['id'=>'46','entidad'=>'Jomagar rotativa','entidadtipo_id'=>'3']);
        Entidad::create(['id'=>'49','entidad'=>'Agrofruit','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'50','entidad'=>'Ainea Perfums','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'51','entidad'=>'Apunts','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'52','entidad'=>'Aqua di Baleares','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'53','entidad'=>'Axceleris Alpiguisa Innovation','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'54','entidad'=>'Bufalo & Frosch','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'55','entidad'=>'Búfalo Wener SA','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'56','entidad'=>'Casabella','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'57','entidad'=>'Dicadia','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'58','entidad'=>'Difusión SCAMP','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'59','entidad'=>'Geresa','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'60','entidad'=>'Lacer','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'61','entidad'=>'Navna soap','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'62','entidad'=>'Nut Creatives','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'63','entidad'=>'Petra Natur','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'64','entidad'=>'Regaleco','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'65','entidad'=>'Remedios Juanita','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'66','entidad'=>'Saül Rossell','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'67','entidad'=>'Smilics Thecnologies ','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'68','entidad'=>'Specials Flavours S.L.','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'69','entidad'=>'Xavi Rodó','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'70','entidad'=>'Advantia','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'71','entidad'=>'Almàssera','entidadtipo_id'=>'1']);
        Entidad::create(['id'=>'72','entidad'=>'Viu Sant Feliu','entidadtipo_id'=>'1']);
    }
}
