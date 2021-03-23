<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InicioCtrl extends Controller
{

    // Inicio
    public function inicio(){
        return view("inicio");
    }
}