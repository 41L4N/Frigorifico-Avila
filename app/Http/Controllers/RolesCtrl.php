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
            'titulo'     =>  'required|max:75',
        ]);

        // Registro

        // Respuesta
    }

    // Eliminar
    public function eliminar(Request $rq){
        
    }
}