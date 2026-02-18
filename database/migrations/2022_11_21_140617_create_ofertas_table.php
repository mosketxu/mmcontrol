<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfertasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned(); // to remove primary key
            $table->integer('tipo');
            $table->primary('id'); //to add primary keys
            $table->foreignId('cliente_id')->constrained('entidades');
            $table->foreignId('contacto_id')->nullable()->nullable()->constrained('entidades');
            $table->string('descripcion');
            $table->date('fecha');
            $table->foreignId('producto_id')->nullable()->constrained('productos');
            $table->double('precio', 15, 6)->default(0.00);
            $table->integer('ud_precio')->default('1');
            $table->integer('cantidad')->default('1');
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
        Schema::dropIfExists('compras');
    }
}
