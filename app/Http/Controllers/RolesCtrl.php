<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Rol;

class RolesCtrl extends Controller
{

    // Roles
    public function roles(){
        return view('roles')
        ->with([
            'roles' => Rol::all()
        ]);
    }

    // Guardar
    public function guardar(Request $rq){

        // Validación
        $rq->validate([
            'titulo'    => 'required|max:75|'.Rule::unique( (new Rol)->getTable() )->ignore($rq->id),
            'permisos'  => 'required'
        ]);

        // Registro
        if (!$r = Rol::find($rq->id)) {
            $r = new Rol;
        }
        $r->titulo = $rq->titulo;
        $r->permisos = json_encode($rq->permisos);
        $r->save();

        // Respuesta
        return back()->with([
            'alerta' => [
                'tipo' => 'success'
            ]
        ]);
    }

    // Eliminar
    public function eliminar(Request $rq){

        // Eliminar
        foreach (Rol::whereIn('id',$rq->resultado)->get(['id']) as $rol) {
            foreach (Usuario::where('rol',$rol->id) as $u) {
                $u->rol = null;
                $u->save();
            }
            $rol->delete();
        }

        // Respuesta
        return back()->with([
            'alerta' => [
                'tipo' => 'success'
            ]
        ]);
    }
}