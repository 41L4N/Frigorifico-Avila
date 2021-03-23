<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        $validacion = $rq->validate([
            'email'     =>  'required|max:75',
            'password'  =>  'required|min:8|max:15'
        ]);

        // Respuesta
        if (Auth::attempt($rq->only("email","password"))){
            return redirect()->route('usuario')->with('alerta',['tipo' => 'success', 'mensaje' => 'bienvenido']);
        }
        return back()->withInput($rq->only('email'))->withErrors([
            'approve' => 'Wrong password or this account not approved yet.',
        ]);
    }

    // Usuario
    public function usuario(){
        $usuario = Auth::user();
        return view("usuarios.usuario",compact('usuario'));
    }
}