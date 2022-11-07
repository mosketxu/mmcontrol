<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidoParcialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedido_parciales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos');
            $table->date('fecha')->nullable();
            $table->bigInteger('cantidad')->nullable()->default(0);
            $table->bigInteger('importe')->nullable()->default(0);
            $table->string('comentario')->nullable();
            $table->string('destino')->nullable();
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
        Schema::dropIfExists('pedido_parciales');
    }
}
