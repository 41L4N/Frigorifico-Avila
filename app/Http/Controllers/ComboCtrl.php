<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Combo;

class ComboCtrl extends Controller
{
    // Registros
    public function registros(){
        return view('combos')->with([
            'combos'    => Combo::all(),
            'productos' => Producto::get(['id', 'titulo'])
        ]);
    }

    // Guardar
    public function guardar(Request $rq){
        
    }

    // Eliminar
    public function eliminar(Request $rq){
        
    }
}