<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pedido')->index();
            $table->foreignId('responsable_id')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('cliente_id')->constrained('entidades');
            $table->foreignId('proveedor_id')->nullable()->constrained('entidades');
            $table->foreignId('producto_id')->constrained('productos');
            $table->date('fechapedido');
            $table->date('fechaarchivos')->nullable();
            $table->date('fechaplotter')->nullable();
            $table->date('fechaentrega')->nullable();
            $table->bigInteger('tiradaprevista')->default(0);
            $table->bigInteger('tiradareal')->default(0);
            $table->double('precio', 15, 2)->nullable()->default(0.00);
            $table->double('preciototal', 15, 2)->nullable()->default(0.00);
            $table->string('parcial')->nullable();
            $table->integer('estado')->default('0');
            $table->boolean('facturado')->default(false);
            $table->string('cd_dvd')->nullable();
            $table->string('distribucion')->nullable();
            $table->string('cajas')->nullable();
            $table->string('incidencias')->nullable();
            $table->string('retardos')->nullable();
            $table->string('otros')->nullable();
            $table->string('fichapedido')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
}
