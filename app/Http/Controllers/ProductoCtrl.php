<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\FiltroProducto;

class ProductoCtrl extends Controller
{

    // Inventario
    public function productos(){
        return view('productos.inventario')->with([
            'productos' => Producto::all()
        ]);
    }

    // Producto

    // Guardar

    // Eliminar
}