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
            $tb->string('nombre');
            $tb->string('apellido');

            // Acceso
            $tb->string('email')->unique();
            $tb->string('codigo_acceso')->nullable();
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
