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
            // $table->id();
            // $table->unsignedBigInteger('id')->primary();
            $table->bigInteger('id')->unsigned(); // to remove primary key
            $table->primary('id'); //to add primary key
            $table->integer('tipo')->default(1);
            $table->string('responsable');
            $table->foreignId('cliente_id')->constrained('entidades');
            $table->foreignId('contacto_id')->nullable()->constrained('entidades');
            $table->foreignId('proveedor_id')->nullable()->constrained('entidades');
            $table->foreignId('facturadopor_id')->nullable()->constrained('entidades');
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
            $table->string('muestra')->nullable();
            $table->string('pruebacolor')->nullable();
            $table->integer('estado')->default('0');
            $table->boolean('facturado')->default(false);
            $table->string('uds_caja')->nullable();
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
        Schema::dropIfExists('pedidos');
    }
}
