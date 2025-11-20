<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
    {
        Schema::table('presupuestos', function (Blueprint $table) {
            $table->text('otros')->nullable()->change();
        });

        Schema::table('pedidos', function (Blueprint $table) {
            $table->text('otros')->nullable()->change();
        });

        Schema::table('pedido_subpedidos', function (Blueprint $table) {
            $table->text('otros')->nullable()->change();
        });

        Schema::table('pedido_tareas', function (Blueprint $table) {
            $table->text('otros')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('presupuestos', function (Blueprint $table) {
            $table->string('otros')->change();
        });

        Schema::table('pedidos', function (Blueprint $table) {
            $table->string('otros')->change();
        });

        Schema::table('pedido_subpedidos', function (Blueprint $table) {
            $table->string('otros')->change();
        });

        Schema::table('pedido_tareas', function (Blueprint $table) {
            $table->string('otros')->change();
        });
    }
};
