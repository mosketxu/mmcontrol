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
            $table->integer('tipo');
            $table->year('anyo');
            $table->unsignedInteger('numero');
            $table->string('codigo')->unique(); // OF-2026-001
            $table->date('fecha');
            $table->date('fechaentrega')->nullable();
            $table->foreignId('proveedor_id')->constrained('entidades');
            $table->string('descripcion');
            $table->foreignId('producto_id')->nullable()->constrained('productos');
            $table->double('precio', 15, 6)->nullable()->default(0.00);
            $table->integer('ud_precio')->default('1');
            $table->integer('cantidad')->default('1');
            $table->double('total', 15, 6)->nullable()->default(0.00);
            $table->string('observaciones')->nullable();
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
