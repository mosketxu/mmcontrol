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
        Schema::create('pedido_tareas', function (Blueprint $table) {
            $table->id(); // Clave primaria
            $table->foreignId('pedido_id') // Clave foránea que referencia a la tabla pedidos
                  ->constrained('pedidos')
                  ->onDelete('cascade'); // Borra tareas si el pedido es eliminado

            $table->string('tarea', 50);
            $table->integer('unidades')->nullable();
            $table->string('otros', 100)->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->string('asignado_a', 100);
            $table->integer('estado')->default(1);

            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedido_tareas');
    }
};
