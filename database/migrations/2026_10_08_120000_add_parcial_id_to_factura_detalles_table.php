<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Vínculo albarán (pedido_parciales) -> línea de factura, para no facturar dos veces un albarán.
    public function up()
    {
        Schema::table('factura_detalles', function (Blueprint $table) {
            $table->unsignedBigInteger('parcial_id')->nullable()->after('pedido_id')->index();
        });
    }

    public function down()
    {
        Schema::table('factura_detalles', function (Blueprint $table) {
            $table->dropIndex(['parcial_id']);
            $table->dropColumn('parcial_id');
        });
    }
};
