<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Models\Cupon;

class CuponCtrl extends Controller
{
    // Lista de registros
    public function registros(){
        return view('cupones')->with([
            'cupones' => Cupon::all()
        ]);
    }

    // Guardar
    public function guardar(Request $rq){
        
        // Validación
        $rq->validate([
            'titulo'            => 'required',
            'oferta'            => 'digits_between:1,3|numeric|min:1|max:100',
            'fecha_vencimiento' => 'date|after:today'
        ]);

        // Registro principal
        if (!$reg = Cupon::find($rq->id)) {
            $reg = new Cupon;
            $reg->codigo = uniqid();
        }
        // Campos directos
        foreach (Schema::getColumnListing( (new Cupon)->getTable() ) as $campo) {
            if ($rq->exists($campo)) {
                $reg->$campo = $rq->$campo;
            }
        }
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

        // Eliminar
        Cupon::whereIn('id', $rq->registros)->delete();

        // Respuesta
        return back()->with([
            'alerta' => [
                'tipo' => 'success'
            ]
        ]);
    }
}