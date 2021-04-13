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
            return redirect()->route('usuario-perfil');
        }

        // Si hay código de acceso pero no coincide
        if ($codigo_acceso && !Usuario::where("codigo_acceso",$codigo_acceso)->exists()) {
            abort(401);
        }

        // Vista de sesion
        return view('sesion');
    }

    // Guardar
    public function guardar(Request $rq){

        // Validación
        $rq->validate([
            'nombre'        => 'required|between:1,50',
            'apellido'      => 'required|between:1,50',
            'email'         => 'required|email|unique:' . (new Usuario)->getTable() . ',email,' . $rq->id . '|between:1,75',
            'telf.codigo'   => 'sometimes|required|numeric|between:1,4',
            'telf.numero'   => 'sometimes|required|numeric|between:10,14',
            'rol'           => 'sometimes|required',
            'password'      => 'sometimes|required|min:8|max:15|required_with:confirmacion_password|same:confirmacion_password',
        ]);

        // Registro
        if (!$reg = Usuario::find($rq->id)) {
            $reg = new Usuario;
        }
        // Campos directos
        foreach (Schema::getColumnListing( (new Usuario)->getTable() ) as $campo) {
            if ($rq->exists($campo)) {
                $reg->$campo = $rq->$campo;
            }
        }
        // Campos adicionales
        // Teléfono
        $reg->telf = json_encode($rq->telf);
        // Contraseña
        if ($rq->exists('password')) {
            $reg->password = bcrypt($rq->password);
        }
        $reg->save();

        // Correo de invitación - Si no hay password es porque lo guardo el administrador
        if (!$reg->password) {

            // Asigno un código de recuperación
            $reg->codigo_acceso = ($codigo = uniqid());
            $reg->save();

            // Correo
            Mail::send("correos.invitacion",[
                "asunto"    =>  $asunto = "Invitación",
                "ruta"      =>  route("sesion", ['renovacion-contraseña',$codigo])
            ],function($m) use ($rq, $asunto){
                $m->to($rq->email);
                $m->subject($asunto);
            });
        }

        // Respuesta
        if (Auth::check()) {
            return back()->with([
                'alerta' => [
                    'tipo' => 'success'
                ]
            ]);
        }
        else {
            return $this->ingreso($rq);
        }
    }

    // Eliminar
    public function eliminar(Request $rq){

        // Eliminar
        Usuario::whereIn('id', $rq->registros)->delete();

        // Respuesta
        return back()->with([
            'alerta' => [
                'tipo' => 'success'
            ]
        ]);
    }

    // Ingreso
    public function ingreso(Request $rq){

        // Validación
        $validacion = Validator::make($rq->all(),[
            'email'     =>  'exists:' . (new Usuario)->getTable() . ',email|required|between:1,75',
            'password'  =>  'required|between:8,15'
        ])->validate();

        // Respuesta - true
        if ( Auth::attempt( $rq->only("email", "password") ) ){
            return back()->with([
                'alerta' => [
                    'tipo'  => 'success',
                    'texto' => 'ingreso'
                ]
            ]);
        }

        // Contraseña incorrecta - Porque el email se verifica arriba
        $validacion = Validator::make($rq->all(),[
            'password' => 'password'
        ]);
        return back()->withErrors($validacion)->withInput(
            $rq->except(['_token','password'])
        );
    }

    // Recuperar contraseña
    public function recuperacionContraseña(Request $rq){

        // Validación
        $rq->validate([
            'email'     =>  'exists:' . (new Usuario)->getTable() . ',email|required|between:1,75'
        ]);

        // Asigno un código de recuperación
        $u = Usuario::where('email', $rq->email)->first();
        $u->codigo_acceso = ($codigo = uniqid());
        $u->save();

        // Envio correo con código de recuperación
        Mail::send("correos.recuperacion",[
            "asunto"    =>  $asunto = "Recuperar contraseña",
            "ruta"      =>  route("sesion", ['renovacion-contraseña',$codigo])
        ],function($m) use ($rq, $asunto){
            $m->to($rq->email);
            $m->subject($asunto);
        });

        // Respuesta
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
            'codigo_acceso' =>  'exists:' . (new Usuario)->getTable() . ',codigo_acceso',
            'password'      =>  'required|between:8,15|required_with:confirmacion_password|same:confirmacion_password'
        ]);

        // Cambio de contraseña
        $u = Usuario::where('codigo_acceso', $rq->codigo_acceso)->first();
        $u->password = bcrypt($rq->password);
        $u->codigo_acceso = null;
        $u->save();

        // Respuesta
        return $this->ingreso(
            new Request([
                'email'     =>  $u->email,
                'password'  =>  $rq->password
            ])
        );
    }

    // Registro
    public function registro(){
        return view("usuarios.usuario")->with([
            'usuario' => Auth::user()
        ]);
    }

    // Registros
    public function registros(){
        return view('usuarios.usuarios')->with([
            'usuarios' => Usuario::whereNull('administrador')->get()
        ]);
    }
}