<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPrecioUdToPedidoparcialDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pedidoparcial_detalles', function (Blueprint $table) {
            $table->double('precio_ud', 15, 6)->nullable()->default(0.00)->after('cantidad');
            $table->double('total', 15, 6)->nullable()->default(0.00)->after('precio_ud');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pedidoparcial_detalles', function (Blueprint $table) {
            $table->dropColumn('total');
        });
    }
}
