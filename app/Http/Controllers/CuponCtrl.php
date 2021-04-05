<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cupon;

class CuponCtrl extends Controller
{
    // Cupones
    public function cupones(){
        return view('cupones')->with([
            'cupones' => Cupon::all()
        ]);
    }

    // Guardar
    public function guardar(Request $rq){
        
    }

    // Eliminar
    public function eliminar(Request $rq){
        
    }
}