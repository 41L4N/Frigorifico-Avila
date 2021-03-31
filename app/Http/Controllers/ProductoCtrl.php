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
            'titulo'            => 'required|alpha_num|between:1,50',
            'filtro'            => 'required|numeric',
            'precio_detal'      => 'required|numeric|digits_between:1,10',
            'pedido_min_detal'  => 'required|numeric|digits_between:1,10',
            'oferta'            => 'required|numeric|digits_between:1,10',
            'precio_mayor'      => 'required|numeric|digits_between:1,10',
            'pedido_min_mayor'  => 'required|numeric|digits_between:1,10',
            'descripcion'       => 'max:500',
            'img'               => 'mimes:jpg,jpeg,png',
        ]);

        // Registro

        // Imagen

        // Respuesta
    }
    
    // Eliminar

    // Productos

    // Producto
}