<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToPedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->boolean('hayArchivos')->nullable()->default(0)->after('transporte');
            $table->boolean('hayDistribuciones')->nullable()->default(0)->after('hayArchivos');
            $table->boolean('hayFacturaciones')->nullable()->default(0)->after('hayDistribuciones');
            $table->boolean('hayIncidencias')->nullable()->default(0)->after('hayFacturaciones');
            $table->boolean('hayParciales')->nullable()->default(0)->after('hayIncidencias');
            $table->boolean('hayRetrasos')->nullable()->default(0)->after('hayParciales');
            $table->boolean('hayFacturacion')->nullable()->default(0)->after('hayRetrasos');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn('hayDistribuciones');
            $table->dropColumn('hayFacturaciones');
            $table->dropColumn('hayIncidencias');
            $table->dropColumn('hayParciales');
            $table->dropColumn('hayRetrasos');
            $table->dropColumn('hayFacturacion');

        });
    }
}
