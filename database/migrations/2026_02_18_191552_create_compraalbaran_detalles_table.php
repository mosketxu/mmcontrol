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
        Schema::create('compraalbaran_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parcial_id')->constrained('pedido_parciales')->onDelete('cascade');
            $table->string('concepto')->nullable();
            $table->bigInteger('cantidad')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compraalbaran_detalles');
    }
};
