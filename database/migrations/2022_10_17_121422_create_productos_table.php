<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->nullable()->constrained('entidades');
            $table->foreignId('proveedor_id')->nullable()->constrained('entidades');
            $table->string('isbn',13)->nullable()->unique()->index();
            $table->string('referencia',150)->unique()->index();
            $table->double('precio', 15, 2)->nullable()->default(0.00);
            $table->longText('observaciones')->nullable();
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
        Schema::dropIfExists('productos');
    }
}
