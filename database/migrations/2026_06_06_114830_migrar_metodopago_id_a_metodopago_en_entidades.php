<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
 // 1. Añadir nuevo campo
        Schema::table('entidades', function (Blueprint $table) {
            $table->string('metodopago')->nullable()->after('metodopago_id');
        });

        // 2. Copiar datos
        DB::statement("
            UPDATE entidades e
            INNER JOIN metodo_pagos mp ON mp.id = e.metodopago_id
            SET e.metodopago = mp.nombre
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entidades', function (Blueprint $table) {
            $table->dropColumn('metodopago');
        });
    }
};
