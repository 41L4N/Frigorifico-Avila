<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Models\Usuario;

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

    // Guardar
    public function guardar(Request $rq){
        
    }

    // Eliminar
    public function eliminar(Request $rq){
        
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
            return redirect()->route('usuario')->with('alerta',['tipo' => 'success', 'msj' => 'autenticacion-true']);
        }
        return back()->withInput($rq->only('email'))->withErrors(['autenticacion-false']);
    }

    // Recuperar contraseña
    public function recuperarContraseña(Request $rq){

        // Validación
        $validacion = $rq->validate([
            'email'     =>  'required|max:75',
            'password'  =>  'required|min:8|max:15'
        ]);

        // Si el usuario no existe
        if(!$usuario = Usuario::where('email',$rq->email)->first()){
            return redirect()->route("recuperar")->with('alerta', ['tipo' => 'danger', 'msj' => 'usuario-no-existe']);
        }

        // Asigno un código de recuperación
        $usuario->codigo_acceso = ($codigo = uniqid());
        $usuario->save();

        // Envio correo con código de recuperación
        Mail::send("correos.recuperacion",[
            "asunto"    =>  $asunto = "Recuperar contraseña",
            "ruta"      =>  route("restablecer",$codigo)
        ],function($m) use ($rq,$asunto){
            $m->to($rq->email);
            $m->subject($asunto);
        });
        return redirect()->route("inicio")->with('alerta', ['tipo' => 'success', 'msj' => 'Se ha enviado un codigo a su correo, por favor revise su buzon para continuar con el proceso']);
        
    }

    // Renovar contraseña
    public function renovarContraseña(){
        if($usuario = Usuario::where('codigo_acceso',$rq->codigo_acceso)->first()){
            $usuario->password = bcrypt($rq->password);
            $usuario->codigo_acceso = null;
            $usuario->save();
            return $this->ingresar($rq);
        }
        else {
            return redirect()->route("incio");
        }
    }

    // Usuario
    public function usuario(){
        $usuario = Auth::user();
        return view("usuarios.usuario",compact('usuario'));
    }
}