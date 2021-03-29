<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoCtrl extends Controller
{

    // Inventario
    public function inventario(){
        return view('productos.inventario')->with([
            'productos' => Producto::all()
        ]);
    }

    // Producto

    // Guardar

    // Eliminar
}