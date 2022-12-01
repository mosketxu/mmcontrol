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
            $table->integer('tipo')->nullable();
            $table->string('isbn')->nullable()->unique()->index();
            $table->string('referencia',150)->unique()->index();
            $table->integer('tirada')->nullable()->default(0);
            $table->string('formato')->nullable();
            $table->boolean('FSC')->nullable();
            $table->string('materialinterior')->nullable();
            $table->string('tintainterior')->nullable();
            $table->string('gramajeinterior')->nullable();
            $table->integer('paginas')->nullable()->default(0);
            $table->string('materialcubierta')->nullable();
            $table->string('tintacubierta')->nullable();
            $table->string('gramajecubierta')->nullable();
            $table->string('plastificado')->nullable();
            $table->string('encuadernado')->nullable();
            $table->boolean('solapa')->nullable();
            $table->string('descripsolapa')->nullable();
            $table->boolean('guardas')->nullable();
            $table->string('descripguardas')->nullable();
            $table->boolean('cd')->nullable();
            $table->string('descripcd')->nullable();
            $table->boolean('novedad')->nullable();
            $table->string('descripnovedad')->nullable();
            $table->foreignId('caja_id')->nullable()->constrained('cajas')->onDelete('cascade');
            $table->integer('udxcaja')->nullable()->default(0);
            $table->string('especiflogistica')->nullable();
            $table->longText('observaciones')->nullable();

            $table->double('preciocoste', 15, 2)->nullable()->default(0.00);
            $table->double('precioventa', 15, 2)->nullable()->default(0.00);
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
