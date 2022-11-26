<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned(); // to remove primary key
            $table->primary('id'); //to add primary key
            $table->foreignId('cliente_id')->constrained('entidades');
            $table->foreignId('contacto_id')->nullable()->constrained('entidades');
            $table->string('pedidocliente')->nullable()->index();
            $table->date('fecha');
            $table->double('importe', 15, 2)->nullable()->default(0.00);
            $table->double('iva', 15, 2)->nullable()->default(0.00);
            $table->double('total', 15, 2)->nullable()->default(0.00);
            $table->integer('estado')->default('0');
            $table->string('observaciones')->nullable();
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
        Schema::dropIfExists('facturas');
    }
}
