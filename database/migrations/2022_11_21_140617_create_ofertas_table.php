<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfertasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ofertas', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned(); // to remove primary key
            $table->primary('id'); //to add primary key
            $table->foreignId('cliente_id')->constrained('entidades');
            $table->foreignId('contacto_id')->nullable()->constrained('entidades');
            $table->foreignId('producto_id')->nullable()->constrained('productos');
            $table->integer('tipo');
            $table->date('fecha');
            $table->string('referencia');
            $table->string('formato')->nullable();
            $table->string('extension')->nullable();
            $table->string('interiorcomposicion')->nullable();
            $table->string('interiorimpresion')->nullable();
            $table->string('cubiertacomposicion')->nullable();
            $table->string('cubiertaimpresion')->nullable();
            $table->string('guardascomposicion')->nullable();
            $table->string('guardasimpresion')->nullable();
            $table->string('acabado')->nullable();
            $table->string('manipulacion')->nullable();
            $table->string('entrega')->nullable();
            $table->string('observaciones')->nullable();
            $table->integer('estado')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ofertas');
    }
}
