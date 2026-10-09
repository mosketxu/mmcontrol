<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Registro de los albaranes enviados por email (a quién, qué texto, qué adjuntos).
    public function up()
    {
        Schema::create('albaran_envios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parcial_id')->index();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('destinatarios');
            $table->string('asunto');
            $table->text('mensaje');
            $table->text('adjuntos')->nullable();
            $table->boolean('valorado')->default(false);
            $table->timestamp('enviado_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('albaran_envios');
    }
};
