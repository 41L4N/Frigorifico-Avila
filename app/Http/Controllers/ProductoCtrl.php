<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\FiltroProducto;

class ProductoCtrl extends Controller
{

    // Inventario
    public function inventario(){
        return view('productos.inventario')->with([
            'filtros'   => FiltroProducto::lista(),
            'productos' => Producto::all()
        ]);
    }

    // Guardar
    public function guardar(Request $rq){
        
        // Validación
        $rq->validate([
            'titulo'            => 'required|between:1,50',
            'filtro'            => 'required|digits_between:1,10',
            'precio_detal'      => 'required|digits_between:1,10',
            'pedido_min_detal'  => 'required|digits_between:1,10',
            'oferta'            => 'nullable|digits_between:1,10',
            'precio_mayor'      => 'nullable|digits_between:1,10',
            'pedido_min_mayor'  => 'nullable|digits_between:1,10',
            'descripcion'       => 'nullable|max:500',
            'img'               => 'nullable|file|image|mimes:jpg,jpeg,png',
        ]);

        // Registro

        // Imagen

        // Respuesta
    }
    
    // Eliminar

    // Productos

    // Producto
}