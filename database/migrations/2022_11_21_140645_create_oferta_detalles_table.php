<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfertaDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oferta_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('oferta_id')->constrained('ofertas')->onDelete('cascade');
            $table->string('titulo')->nullable();
            $table->string('concepto')->nullable();
            $table->integer('cantidad')->default('0');
            $table->double('importe', 15, 2)->nullable()->default(0.00);
            $table->double('total', 15, 2)->nullable()->default(0.00);
            $table->string('observaciones')->nullable();
            $table->integer('orden')->nullable()->default('0');
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
        Schema::dropIfExists('oferta_detalles');
    }
}
