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
        Schema::table('presupuestos', function (Blueprint $table) {
            $table->foreignId('idioma_id')
                ->default(1)
                ->after('cliente_id')
                ->constrained('idiomas');
        });

        DB::table('presupuestos')
            ->whereNull('idioma_id')
            ->update(['idioma_id' => 1]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presupuestos', function (Blueprint $table) {
            $table->dropConstrainedForeignId('idioma_id');
        });
    }
};
