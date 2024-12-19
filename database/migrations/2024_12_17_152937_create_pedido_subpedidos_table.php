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
        Schema::create('pedido_subpedidos', function (Blueprint $table) {
            $table->id(); // Clave primaria
            $table->foreignId('pedido_id') // Clave foránea que referencia a la tabla pedidos
                  ->constrained('pedidos') // Hace referencia a la tabla pedidos
                  ->onDelete('cascade'); // Borra los subpedidos si el pedido principal se elimina

            $table->string('referencia', 50);
            $table->integer('unidades')->nullable()->default(0);
            $table->string('otros', 100)->nullable();
            $table->date('fecha_archivos')->nullable();
            $table->date('fecha_plotters')->nullable();
            $table->date('fecha_entrega')->nullable();

            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedido_subpedidos');
    }
};
