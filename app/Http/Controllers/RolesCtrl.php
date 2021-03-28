<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
            'titulo'    => 'required|max:75',
            'permisos'  => 'required'
        ]);

        // Que no sea repetido
        if ( Rol::where($c='titulo',$rq->$c)->where('id','!=',$rq->id)->exists() ) {
            return back()->with([
                'id' => $rq->id
            ])->withErrors(
                $rq->validate([
                    $c => 'unique:roles,'.$c
                ])
            );
        }

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