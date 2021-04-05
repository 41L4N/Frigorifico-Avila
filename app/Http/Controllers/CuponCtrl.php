<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Cupon;

class CuponCtrl extends Controller
{
    // Cupones
    public function cupones(){
        return view('cupones')->with([
            'cupones'   => Cupon::all(),
            'productos' => Producto::get(['id','titulo'])
        ]);
    }

    // Guardar
    public function guardar(Request $rq){
        
    }

    // Eliminar
    public function eliminar(Request $rq){
        
    }
}