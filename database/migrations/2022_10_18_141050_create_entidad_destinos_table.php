<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntidadDestinosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entidad_destinos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entidad_id')->constrained('entidades');
            $table->string('destino');
            $table->string('atencion')->nullable();
            $table->string('direccion')->nullable();
            $table->string('localidad')->nullable();
            $table->string('cp')->nullable();
            $table->string('horario')->nullable();
            $table->string('tfno')->nullable();
            $table->string('observaciones')->nullable();
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
        Schema::dropIfExists('entidad_destinos');
    }
}
