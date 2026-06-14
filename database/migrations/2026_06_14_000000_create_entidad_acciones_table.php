<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntidadAccionesTable extends Migration
{
    public function up()
    {
        Schema::create('entidad_acciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entidad_id')->constrained('entidades')->onDelete('cascade');
            $table->foreignId('contacto_id')->nullable()->constrained('entidad_contactos')->nullOnDelete();
            $table->string('nombre')->nullable();
            $table->text('accion')->nullable();
            $table->text('descripcion')->nullable();
            $table->date('fechaaccion');
            $table->string('proximaaccion')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('entidad_acciones');
    }
}
