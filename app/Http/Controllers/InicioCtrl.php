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
            'is_imgs_carrusel'  => 'array',
            'imgs_carrusel'     => 'array'
        ]);

        // Imágenes
        foreach ($rq->is_imgs_carrusel as $iImg) {
            if ( isset($rq->imgs_carrusel[$iImg]) ) {
                guardarImg('carrusel', $rq->imgs_carrusel[$iImg], $iImg++);
            }
        }

        $nuevas = [];
        foreach ($rq->is_imgs_carrusel as $iImg) {
            if ( almacenImgs()->exists($ruta = "carrusel_$iImg.json") ) {
                array_push($nuevas, almacenImgs()->get($ruta) );
                almacenImgs()->delete($ruta);
            }
        }
        foreach ($nuevas as $iN => $n) {
            almacenImgs()->put("carrusel_$iN.json", $n);
        }

        // Respuesta
        return back()->with([
            'alerta'    => [
                'tipo' => 'success'
            ]
        ]);
    }
}