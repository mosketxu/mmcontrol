<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddFechaIniToEntidadesTable extends Migration
{
    public function up()
    {
        Schema::table('entidades', function (Blueprint $table) {
            $table->date('fecha_ini')->nullable()->after('entidadtipo_id');
        });

        DB::table('entidades')
            ->whereNull('fecha_ini')
            ->update(['fecha_ini' => DB::raw('DATE(created_at)')]);
    }

    public function down()
    {
        Schema::table('entidades', function (Blueprint $table) {
            $table->dropColumn('fecha_ini');
        });
    }
}
