<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cuentas_bancarias', function (Blueprint $table) {
            $table->id();
            $table->string('iban');
            $table->string('bic')->nullable();
            $table->string('moneda', 5);
            $table->boolean('es_defecto')->default(false);
            $table->timestamps();
        });

        // Cuenta que hasta ahora estaba fija (hardcoded) en el PDF de factura.
        DB::table('cuentas_bancarias')->insert([
            'iban' => 'ES47 0182 8611 7602 0010 3154',
            'bic' => null,
            'moneda' => '€',
            'es_defecto' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Cuenta en dólares para clientes que pagan en USD.
        DB::table('cuentas_bancarias')->insert([
            'iban' => 'ES3901824915942010000114',
            'bic' => 'BBVAESMMXXX',
            'moneda' => '$',
            'es_defecto' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Schema::table('entidades', function (Blueprint $table) {
            // default(1): la cuenta habitual insertada arriba, que se queda con id 1
            // en esta tabla recién creada. MySQL rellena con ese valor todas las
            // filas ya existentes de entidades al añadir la columna.
            $table->unsignedBigInteger('cuenta_bancaria_id')
                  ->after('iban2')
                  ->default(1);

            $table->foreign('cuenta_bancaria_id')
                  ->references('id')
                  ->on('cuentas_bancarias')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entidades', function (Blueprint $table) {
            $table->dropForeign(['cuenta_bancaria_id']);
            $table->dropColumn('cuenta_bancaria_id');
        });

        Schema::dropIfExists('cuentas_bancarias');
    }
};
