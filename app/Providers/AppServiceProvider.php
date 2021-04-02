<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Models\Producto;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {   
        // Lista productos en cache
        foreach ($listaCompras = ($lC = Cache::get('lista-compras')) ? $lC : [] as $iC => $c) {

            // Producto
            // Si producto no existe entonces se borra de la lista
            if (!$p = Producto::find($c['id'])) {
                unset($listaCompras[$iC]);
                continue;
            }

            // Precio de venta según cantidad y oferta
            $p->cantidad = $c['cantidad'];
            $p->precio_venta = ($p->cantidad >= $p->pedido_min_mayor) ? $p->precio_mayor : ($precioD = $p->precio_detal) - $p->oferta * $precioD / 100;

            // Titulo
            $listaCompras[$iC] = $p;
        }
        
        // Respuesta
        View::share(['listaCompras' => $listaCompras]);
    }
}
