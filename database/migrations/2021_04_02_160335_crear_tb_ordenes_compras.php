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
            $tb->string('codigo');
            $tb->integer('id_usuario');
            $tb->text('datos_facturacion')->nullable();
            $tb->text('direccion_envio')->nullable();
            $tb->text('articulos');
            $tb->string('total');
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
