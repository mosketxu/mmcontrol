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
            $table->integer('consumo') // Campo consumo
                  ->after('laminado_id')
                  ->default('0');

            $table->string('unidad_consumo',50) // Campo unidad_consumo
                  ->after('consumo')
                  ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn(['consumo', 'unidad_consumo']);
        });
    }
};
