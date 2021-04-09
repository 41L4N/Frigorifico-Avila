<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FiltroProducto;
use App\Models\Producto;

class InicioCtrl extends Controller
{

    // Inicio
    public function inicio(){
        $isCarrusel = glob( storage_path("app/public/carrusel_*.json") );
        return view("inicio")->with([
            'isCarrusel'        => array_map(function ($xx){
                                    return explode('_', pathinfo($xx)['filename'])[1];
                                }, $isCarrusel),
            'productos'         => [
                'mas_visitados' => Producto::orderBy('n_visitas', 'DESC')->limit(6)->get(),
                'mas_nuevos'    => Producto::orderBy('created_at', 'DESC')->limit(6)->get()
            ],
            'filtros_productos' => FiltroProducto::all()
        ]);
    }

    // Carrusel
    public function carrusel(Request $rq){

        // Validación
        $rq->validate([
            'imgs_carrusel' => 'array'
        ]);

        // Imágenes
        foreach (($imgs = $rq->imgs_carrusel) ? $imgs : [] as $iImg => $img) {
            guardarImg('carrusel', $img, $iImg);
        }

        // Respuesta
        return back()->with([
            'alerta'    => [
                'tipo' => 'success'
            ]
        ]);
    }
}