<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rol;

class RolesCtrl extends Controller
{

    // Roles
    public function roles(){
        return view('usuarios.roles')
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
        if ( Rol::where('titulo',$rq->titulo)->where('id','!=',$rq->id)->exists() ) {
            return back()->with([
                'id' => $rq->id
            ])->withErrors(
                $rq->validate([
                    'titulo' => 'unique:roles,titulo'
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
        Rol::whereIn('id',$rq->resultados)->delete();
        
        // Respuesta
        return back()->with([
            'alerta' => [
                'tipo' => 'success'
            ]
        ]);
    }
}