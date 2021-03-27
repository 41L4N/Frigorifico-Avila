<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rol;

class RolesCtrl extends Controller
{

    // Roles
    public function roles(){
        return view('usuarios.roles')
        ->with(
            'roles',
            Rol::all()
        );
    }

    // Guardar
    public function guardar(Request $rq){

        // Validación
        $rq->validate([
            'titulo'    =>  'required|max:75',
            'permisos'  =>  'required'
        ]);

        // Registro
        if (!$r = Rol::find($rq->id)) {
            $rq->validate([
                'titulo'    =>  'unique:roles,titulo',
            ]);
            $r = new Rol;
        }
        $r->titulo = $rq->titulo;
        $r->permisos = json_encode($rq->permisos);
        $r->save();

        // Respuesta
        return back()->with('alerta', ['tipo' => 'success']);
    }

    // Eliminar
    public function eliminar(Request $rq){
        Rol::whereIn('id',$rq->resultados)->delete();
        return back()->with('alerta', ['tipo' => 'success']);
    }
}