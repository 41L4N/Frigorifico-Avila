<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use App\Models\Usuario;
use App\Models\Rol;

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

        // Validación
        $rq->validate([
            'nombre'    => 'required|max:50',
            'apellido'  => '',
            'email'     => '',
            'telf'      => ''
        ]);
        if (isset($rq->rol)) {
            $rq->validate([
                'rol' => '',
            ]);
        }

        // Registro
        if (!$u = Usuario::find($rq->id)) {
            $rq->validate([
                'email' => 'unique:usuarios,email',
            ]);
            $u = new Usuario;
        }
        // Campos directos
        foreach (Schema::getColumnListing('usuarios') as $campo) {
            if ($rq->exists($campo) && $campo!="id") {
                $art->$campo = $rq->$campo;
            }
        }
        // Teléfono
        $u->telf = json_encode($rq->telf);
        $u->save();

        // Respuesta
    }

    // Eliminar
    public function eliminar(Request $rq){
        
    }

    // Ingreso
    public function ingreso(Request $rq){

        // Validación
        $rq->validate([
            'email'     =>  'exists:usuarios,email|required|max:75',
            'password'  =>  'required|min:8|max:15'
        ]);

        // Respuesta
        if (Auth::attempt($rq->only("email","password"))){
            return redirect()->route('usuario.perfil')->with([
                'alerta' => [
                    'tipo'  => 'success',
                    'texto' => 'ingreso'
                ]
            ]);
        }
    }

    // Recuperar contraseña
    public function recuperacionContraseña(Request $rq){

        // Validación
        $rq->validate([
            'email'     =>  'exists:usuarios,email|required|max:75'
        ]);

        // Asigno un código de recuperación
        $u = Usuario::where('email',$rq->email)->first();
        $u->codigo_acceso = ($codigo = uniqid());
        $u->save();

        // Envio correo con código de recuperación
        Mail::send("correos.recuperacion",[
            "asunto"    =>  $asunto = "Recuperar contraseña",
            "ruta"      =>  route("sesion",['renovacion-contraseña',$codigo])
        ],function($m) use ($rq,$asunto){
            $m->to($rq->email);
            $m->subject($asunto);
        });
        return redirect()->route("inicio")->with([
            'alerta' => [
                'tipo' => 'success',
                'texto' => 'recuperacion-contraseña'
            ]
        ]);
    }

    // Renovar contraseña
    public function renovacionContraseña(Request $rq){

        // Validación
        $rq->validate([
            'codigo_acceso' =>  'exists:usuarios,codigo_acceso',
            'password'      =>  'required|min:8|max:15|required_with:confirmacion_password|same:confirmacion_password'
        ]);

        // Cambio de contraseña
        $u = Usuario::where('codigo_acceso',$rq->codigo_acceso)->first();
        $u->password = bcrypt($rq->password);
        $u->codigo_acceso = null;
        $u->save();
        return $this->ingreso(
            new Request([
                'email'     =>  $u->email,
                'password'  =>  $rq->password
            ])
        );
    }

    // Usuario
    public function usuario(){
        return view("usuarios.usuario")->with([
            'usuario' => Auth::user()
        ]);
    }

    // Usuarios
    public function usuarios(){
        return view('usuarios.usuarios')->with([
            'usuarios'  =>  Usuario::where('administrador',false)->get(),
            'roles'     =>  Rol::all()
        ]);
    }
}