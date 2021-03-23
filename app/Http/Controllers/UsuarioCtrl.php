<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuarioCtrl extends Controller
{

    // Ingresar
    public function ingresar(Request $rq){

        // Validación
        
        // Respuesta
        if (Auth::attempt($rq->only("email","password"))){
            dd("Si...");
            return back()->with('alerta',['tipo' => 'success', 'mensaje' => 'Bienvenido']);
        }
        // return back()->with('alerta',['tipo' => 'danger', 'mensaje' => 'Datos inválidos, por favor intente de nuevo']);
    }
}