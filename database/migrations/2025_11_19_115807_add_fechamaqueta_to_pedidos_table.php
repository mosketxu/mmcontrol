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
            $table->date('fechamaqueta')->nullable()->after('fechaarchivos');
            $table->integer('ctrmaqueta')->nullable()->default(0)->after('fechamaqueta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn('fechamaqueta');
            $table->dropColumn('ctrmaqueta');
        });
    }
};
