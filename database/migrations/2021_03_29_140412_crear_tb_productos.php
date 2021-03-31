<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTbProductos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $tb) {

            $tb->id();
            $tb->string('titulo');
            $tb->string('filtro');
            $tb->string('precio_detal');
            $tb->string('pedido_min_detal')->nullable();
            $tb->string('oferta')->nullable();
            $tb->string('precio_mayor')->nullable();
            $tb->string('pedido_min_mayor')->nullable();
            $tb->string('descripcion')->nullable();
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
        Schema::dropIfExists('productos');
    }
}
