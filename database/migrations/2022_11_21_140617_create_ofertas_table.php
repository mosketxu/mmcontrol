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
            $table->primary('id'); //to add primary keys
            $table->foreignId('cliente_id')->constrained('entidades');
            $table->foreignId('contacto_id')->nullable()->nullable()->constrained('entidades');
            $table->foreignId('producto_id')->nullable()->constrained('productos');
            $table->string('descripcion');
            $table->integer('tipo');
            $table->date('fecha');
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
