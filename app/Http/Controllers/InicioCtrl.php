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
            'productos' => Producto::all(),
            'filtros'   => FiltroProducto::all()
        ]);
    }
}