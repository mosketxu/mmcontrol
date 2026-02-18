<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned(); // to remove primary key
            $table->primary('id'); //to add primary keys
            $table->date('fecha');
            $table->foreignId('proveedor_id')->constrained('proveedores');
            $table->string('descripcion');
            $table->foreignId('producto_id')->nullable()->constrained('productos');
            $table->integer('tipo');
            $table->string('acabado')->nullable();
            $table->string('manipulacion')->nullable();
            $table->string('material')->nullable();
            $table->string('medidas')->nullable();
            $table->string('impresion')->nullable();
            $table->string('embalaje')->nullable();
            $table->string('entrega')->nullable();
            $table->string('transporte')->nullable();
            $table->string('observaciones')->nullable();
            $table->integer('estado')->default('0');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};
