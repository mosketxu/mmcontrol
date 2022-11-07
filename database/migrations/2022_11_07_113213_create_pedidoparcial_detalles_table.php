<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidoparcialDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidoparcial_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parcial_id')->constrained('pedido_parciales');
            $table->string('concepto')->nullable();
            $table->bigInteger('cantidad')->nullable();
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
        Schema::dropIfExists('pedidoparcial_detalles');
    }
}
