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
            $table->boolean('haySubpedidos')->nullable()->default(0)->after('hayFacturacion');
            $table->boolean('hayTareas')->nullable()->default(0)->after('haySubpedidos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn('haySubpedidos');
            $table->dropColumn('hayTareas');
        });
    }
};
