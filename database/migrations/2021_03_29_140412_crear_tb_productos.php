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
            $tb->string('unidad_medida');
            $tb->string('filtro');
            $tb->string('pedido_min_detal')->default(1);
            $tb->string('precio_detal')->default(1);
            $tb->string('pedido_min_oferta')->default(0);
            $tb->string('oferta')->default(0);
            $tb->string('pedido_min_mayor')->nullable();
            $tb->string('precio_mayor')->nullable();
            $tb->string('descripcion')->nullable();
            $tb->integer('n_visitas')->default(0);
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
