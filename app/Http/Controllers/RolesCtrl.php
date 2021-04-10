<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Rol;

class RolesCtrl extends Controller
{

    // Registros
    public function registros(){
        return view('roles')
        ->with([
            'roles' => Rol::all()
        ]);
    }

    // Guardar
    public function guardar(Request $rq){

        // Validación
        $rq->validate([
            'titulo'    => 'required|unique:' . (new Rol)->getTable() . ',titulo,' . $rq->id . '|between:1,50|',
            'permisos'  => 'required'
        ]);

        // Registro
        if (!$reg = Rol::find($rq->id)) {
            $reg = new Rol;
        }
        $reg->titulo = $rq->titulo;
        $reg->permisos = json_encode($rq->permisos);
        $reg->save();

        // Respuesta
        return back()->with([
            'alerta' => [
                'tipo' => 'success'
            ]
        ]);
    }

    // Eliminar
    public function eliminar(Request $rq){

        // Usuarios relacionados
        Usuario::whereIn('rol', $rq->registros)->update(['rol' => null]);

        // Registros
        Rol::whereIn('id', $rq->registros)->delete();

        // Respuesta
        return back()->with([
            'alerta' => [
                'tipo' => 'success'
            ]
        ]);
    }
}