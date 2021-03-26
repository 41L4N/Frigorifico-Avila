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
    public function sesion($seccion,$codigo_acceso=null){

        // Si ya hay autenticación
        if(Auth::check()){
            return redirect()->route('usuario');
        }

        // Si hay código de acceso pero no coincide
        if ($codigo_acceso && !Usuario::where("codigo_acceso",$codigo_acceso)->exists()) {
            abort(401);
        }

        // Vista de sesion
        return view('usuarios.sesion');
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
    public function recuperacionContraseña(Request $rq){

        // Validación
        $validacion = $rq->validate([
            'email'     =>  'required|max:75'
        ]);

        // Si el usuario no existe
        if(!$usuario = Usuario::where('email',$rq->email)->first()){
            return back()->with('alerta', ['tipo' => 'danger', 'msj' => 'recuperacion-contraseña-false']);
        }

        // Asigno un código de recuperación
        $usuario->codigo_acceso = ($codigo = uniqid());
        $usuario->save();

        // Envio correo con código de recuperación
        Mail::send("correos.recuperacion",[
            "asunto"    =>  $asunto = "Recuperar contraseña",
            "ruta"      =>  route("sesion",['renovacion-contraseña',$codigo])
        ],function($m) use ($rq,$asunto){
            $m->to($rq->email);
            $m->subject($asunto);
        });
        return redirect()->route("inicio")->with('alerta', ['tipo' => 'success', 'msj' => 'recuperacion-contraseña-true']);
    }

    // Renovar contraseña
    public function renovacionContraseña(Request $rq){

        // Validación
        $validacion = $rq->validate([
            'codigo_acceso'             =>  'exists:usuarios,codigo_acceso',
            'password'                  =>  'required|min:8|max:15|required_with:confirmacion_password|same:confirmacion_password'
        ]);

        // Cambio de contraseña
        $usuario = Usuario::where('codigo_acceso',$rq->codigo_acceso)->first();
        $usuario->password = bcrypt($rq->password);
        $usuario->codigo_acceso = null;
        $usuario->save();
        return $this->ingreso(
            new Request([
                'email'     =>  $usuario->email,
                'password'  =>  $rq->password
            ])
        );
    }

    // Usuario
    public function usuario(){
        $usuario = Auth::user();
        return view("usuarios.usuario",compact('usuario'));
    }
}