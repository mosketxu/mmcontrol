<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresupuestosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presupuestos', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned(); // to remove primary key
            $table->primary('id'); //to add primary key();
            $table->integer('tipo')->default(1);
            $table->string('responsable')->nullable();
            $table->string('descripcion')->nullable();
            $table->foreignId('cliente_id')->constrained('entidades');
            $table->foreignId('contacto_id')->nullable()->constrained('entidades');
            $table->foreignId('proveedor_id')->nullable()->constrained('entidades');
            $table->integer('facturadopor')->default('1');
            $table->string('tirada')->default('0');
            $table->double('precio_ud', 15, 4)->nullable()->default(0.00);
            $table->double('preciototal', 15, 2)->nullable()->default(0.00);
            $table->date('fechapresupuesto');
            $table->integer('estado')->default('0');
            $table->boolean('espedido')->default(false);
            $table->bigInteger('pedido')->nullable();
            $table->foreignId('caja_id')->nullable()->constrained('cajas')->onDelete('cascade');
            $table->string('uds_caja')->nullable();
            $table->string('manipulacion')->nullable();
            $table->string('transporte')->nullable();
            $table->string('especificacioneslogisticas')->nullable();
            $table->string('otros')->nullable();
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
        Schema::dropIfExists('presupuestos');
    }
}
