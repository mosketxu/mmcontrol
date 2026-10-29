<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // «Foto» de los datos del cliente con los que sale cada factura (cli_*) y PDF fijo (pdf_*).
    // - datos_congelados_at: null = se leen en vivo del cliente; con fecha = se usa la foto.
    // - datos_origen: 'emision' (foto tomada al crear la factura), 'actual' (relleno de las facturas anteriores con los
    //   datos del cliente de ese día, SIN verificar) o 'historico' (corregido con los datos antiguos y su fecha de corte).
    public function up()
    {
        Schema::table('facturas', function (Blueprint $table) {
            $table->string('cli_entidad')->nullable()->after('observaciones');
            $table->string('cli_direccion')->nullable()->after('cli_entidad');
            $table->string('cli_cp', 20)->nullable()->after('cli_direccion');
            $table->string('cli_localidad')->nullable()->after('cli_cp');
            $table->string('cli_nif', 50)->nullable()->after('cli_localidad');
            $table->string('cli_iban', 50)->nullable()->after('cli_nif');
            $table->string('cli_bic', 20)->nullable()->after('cli_iban');
            $table->string('cli_moneda', 10)->nullable()->after('cli_bic');
            $table->string('datos_origen', 20)->nullable()->after('cli_moneda');
            $table->timestamp('datos_congelados_at')->nullable()->after('datos_origen');
            $table->string('pdf_path')->nullable()->after('datos_congelados_at');
            $table->string('pdf_sha256', 64)->nullable()->after('pdf_path');
            $table->timestamp('pdf_generado_at')->nullable()->after('pdf_sha256');
        });

        // Facturas ya creadas: foto con los datos actuales del cliente (marcada «actual» hasta corregir las que cambiaron).
        DB::statement("UPDATE facturas f
            JOIN entidades e ON e.id = f.cliente_id
            LEFT JOIN cuentas_bancarias c ON c.id = e.cuenta_bancaria_id
            SET f.cli_entidad = e.entidad, f.cli_direccion = e.direccion, f.cli_cp = e.cp, f.cli_localidad = e.localidad,
                f.cli_nif = e.nif, f.cli_iban = c.iban, f.cli_bic = c.bic, f.cli_moneda = c.moneda,
                f.datos_origen = 'actual', f.datos_congelados_at = NOW()
            WHERE f.cliente_id IS NOT NULL");
    }

    public function down()
    {
        Schema::table('facturas', function (Blueprint $table) {
            $table->dropColumn(['cli_entidad','cli_direccion','cli_cp','cli_localidad','cli_nif','cli_iban','cli_bic','cli_moneda',
                'datos_origen','datos_congelados_at','pdf_path','pdf_sha256','pdf_generado_at']);
        });
    }
};
