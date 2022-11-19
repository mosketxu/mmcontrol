<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturaDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factura_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('factura_id')->constrained('facturas');
            $table->foreignId('pedido_id')->constrained('pedidos');
            $table->string('concepto')->nullable();
            $table->bigInteger('cantidad')->default(0.00);
            $table->integer('unidad');
            $table->double('importe', 15, 2)->nullable()->default(0.00);
            $table->double('iva', 15, 2)->default(0.21);
            $table->double('subtotalsiniva', 15, 2)->default(0.21);
            $table->double('subtotaliva', 15, 2)->default(0.21);
            $table->double('subtotal', 15, 2)->default(0.21);
            $table->integer('orden')->default('0');
            $table->boolean('visible')->default(false);
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
        Schema::dropIfExists('factura_detalles');
    }
}
