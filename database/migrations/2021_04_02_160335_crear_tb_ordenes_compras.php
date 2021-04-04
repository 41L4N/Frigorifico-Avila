<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTbOrdenesCompras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordenes_compras', function (Blueprint $tb) {
            $tb->id();
            $tb->string('nombre');
            $tb->string('apellido');
            $tb->string('nombre_empresa');
            $tb->text('direccion');
            $tb->string('email');
            $tb->string('telf');
            $tb->text('direccion_envio')->nullable();
            $tb->text('articulos');
            $tb->string('cupon');
            $tb->text('total');
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
        Schema::dropIfExists('ordenes_compras');
    }
}
