<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfertaProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oferta_productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('oferta_id')->constrained('ofertas')->onDelete('cascade');
            $table->foreignId('producto_id')->nullable()->constrained('productos');
            $table->bigInteger('tirada')->default(0);
            $table->double('precio_ud', 15, 2)->nullable()->default(0.00);
            $table->double('preciototal', 15, 2)->nullable()->default(0.00);
            $table->string('observaciones')->nullable();
            $table->boolean('visible')->nullable()->default('1');
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
        Schema::dropIfExists('oferta_productos');
    }
}
