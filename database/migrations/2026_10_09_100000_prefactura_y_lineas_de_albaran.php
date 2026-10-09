<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // - factura_detalles.parcialdetalle_id: línea de albarán concreta que se facturó (permite facturar un albarán a medias).
    // - facturas.validada_at: null = prefactura (borrador); con fecha = factura creada. Las facturas anteriores se dan por creadas.
    public function up()
    {
        Schema::table('factura_detalles', function (Blueprint $table) {
            $table->unsignedBigInteger('parcialdetalle_id')->nullable()->after('parcial_id')->index();
        });
        Schema::table('facturas', function (Blueprint $table) {
            $table->timestamp('validada_at')->nullable()->after('observaciones');
        });
        DB::table('facturas')->update(['validada_at' => DB::raw('COALESCE(created_at, fecha)')]);
    }

    public function down()
    {
        Schema::table('factura_detalles', function (Blueprint $table) {
            $table->dropIndex(['parcialdetalle_id']);
            $table->dropColumn('parcialdetalle_id');
        });
        Schema::table('facturas', function (Blueprint $table) {
            $table->dropColumn('validada_at');
        });
    }
};
