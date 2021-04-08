<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\FiltroProducto;
use App\Models\Producto;

class InicioCtrl extends Controller
{

    // Inicio
    public function inicio(){
        return view("inicio")->with([
            'nsCarrusel'    => count( glob( storage_path("app/public/carrusel_*.json") ) ),
            'productos'     => [
                'mas_visitados' => Producto::orderBy('n_visitas', 'DESC')->limit(6)->get(),
                'mas_nuevos'    => Producto::orderBy('created_at', 'DESC')->limit(6)->get()
            ],
            'filtros'   => FiltroProducto::all()
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