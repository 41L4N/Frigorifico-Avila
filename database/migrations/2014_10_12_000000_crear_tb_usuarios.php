<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTbUsUarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $tb) {

            // Identificación
            $tb->id();
            // Datos personales
            $tb->string('nombre');
            $tb->string('apellido');
            // Contacto
            $tb->string('email')->unique();
            // Boletin
            $tb->boolean('notificaciones')->nullable();
            // Acceso
            $tb->boolean('administrador')->nullable();
            $tb->integer('rol')->nullable();
            $tb->string('codigo_acceso')->nullable();
            // Seguridad
            $tb->string('password');
            $tb->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}