<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidoFacturacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedido_facturaciones', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned(); // to remove primary key
            $table->primary('id'); //to add primary key
            $table->foreignId('pedido_id')->constrained('pedidos')->onDelete('cascade');
            $table->foreignId('cliente_id')->constrained('entidades');
            $table->date('fecha')->nullable();
            $table->bigInteger('cantidad')->nullable()->default(0);
            $table->bigInteger('importe')->nullable()->default(0);
            $table->integer('estado')->default(0);
            $table->string('comentario')->nullable();
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
        Schema::dropIfExists('pedido_facturaciones');
    }
}
