<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Huella del contenido de la factura (cabecera, líneas y datos del cliente) en el momento de generar su PDF fijo:
    // si luego cambia, se avisa de que el PDF guardado ya no refleja la factura y se ofrece validarla (regenerarlo).
    public function up()
    {
        Schema::table('facturas', function (Blueprint $table) {
            $table->string('pdf_huella', 40)->nullable()->after('pdf_sha256');
        });
    }

    public function down()
    {
        Schema::table('facturas', function (Blueprint $table) {
            $table->dropColumn('pdf_huella');
        });
    }
};
