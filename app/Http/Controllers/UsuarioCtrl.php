<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuarioCtrl extends Controller
{

    // Sesion
    public function sesion(){
        if (Auth::check()) {
            return redirect()->route('usuario');
        }
        else {
            return view('usuarios.sesion');
        }
    }

    // Ingreso
    public function ingreso(Request $rq){

        // Validación

        // Respuesta
        if (Auth::attempt($rq->only("email","password"))){
            return redirect()->route('usuario')->with('alerta',['tipo' => 'success', 'mensaje' => 'Bienvenido']);
        }
        return back()->with('alerta',['tipo' => 'danger', 'mensaje' => 'Datos inválidos, por favor intente de nuevo']);
    }

    // Usuario
    public function usuario(){
        $usuario = Auth::user();
        return view("usuarios.usuario",compact('usuario'));
    }
}