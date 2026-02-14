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
        Schema::table('productos', function (Blueprint $table) {
            $table->string('desarrollocaja')->nullable()->after('impresion');
            $table->string('gramajecaja')->nullable()->after('desarrollocaja');
            $table->string('acabadocaja')->nullable()->after('gramajecaja');
            $table->string('medidasnido')->nullable()->after('acabadocaja');
            $table->string('materialnido')->nullable()->after('medidasnido');
            $table->string('impresionnido')->nullable()->after('materialnido');
            $table->string('procesospack')->nullable()->after('impresionnido');
            $table->string('manipulacion')->nullable()->after('procesospack');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn('desarrollocaja');
            $table->dropColumn('gramajecaja');
            $table->dropColumn('acabadocaja');
            $table->dropColumn('medidasnido');
            $table->dropColumn('materialnido');
            $table->dropColumn('impresionnido');
            $table->dropColumn('procesospack');
            $table->dropColumn('manipulacion');
        });
    }
};
