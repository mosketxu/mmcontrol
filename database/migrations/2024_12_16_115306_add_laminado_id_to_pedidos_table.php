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
        Schema::table('pedidos', function (Blueprint $table) {
            $table->unsignedBigInteger('laminado_id') // Campo para la relación
                  ->after('laminadoplastico')        // Ubicación después de 'laminadoplastico'
                  ->default(1);                     // Valor por defecto

            // Definición de la clave foránea
            $table->foreign('laminado_id')
                  ->references('id')
                  ->on('laminados')
                  ->cascadeOnUpdate()              // Actualización en cascada
                  ->restrictOnDelete();            // Restricción en eliminación
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            // Eliminar la clave foránea antes de eliminar la columna
            $table->dropForeign(['laminado_id']);
            $table->dropColumn('laminado_id');
        });
    }
};
