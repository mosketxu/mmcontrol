<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Correo de envío por usuario: contraseña de su buzón (encriptada) y «ahora no» (usa el correo por defecto del servidor).
return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('mail_password')->nullable();
            $table->boolean('mail_rechazado')->default(false);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['mail_password', 'mail_rechazado']);
        });
    }
};
