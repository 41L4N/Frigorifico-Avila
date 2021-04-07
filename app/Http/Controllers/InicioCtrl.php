<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FiltroProducto;
use App\Models\Producto;

class InicioCtrl extends Controller
{

    // Inicio
    public function inicio(){
        return view("inicio")->with([
            'productos' => [
                'mas_visitados' => Producto::orderBy('n_visitas', 'DESC')->limit(6)->get(),
                'mas_nuevos'    => Producto::orderBy('created_at', 'DESC')->limit(6)->get()
            ],
            'filtros'   => FiltroProducto::all()
        ]);
    }
}