<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsControlfechasToPedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->integer('ctrarchivos')->nullable()->default(0)->after('fechaarchivos');
            $table->integer('ctrplotter')->nullable()->default(0)->after('fechaplotter');
            $table->integer('ctrentrega')->nullable()->default(0)->after('fechaentrega');

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
            $table->dropColumn('ctrarchivos');
            $table->dropColumn('ctrplotter');
            $table->dropColumn('ctrentrega');
        });
    }
}
