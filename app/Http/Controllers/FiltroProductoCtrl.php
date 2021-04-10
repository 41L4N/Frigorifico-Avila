<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FiltroProducto;

class FiltroProductoCtrl extends Controller
{
    // Registros
    public function registros(){
        return view('productos.filtros')->with([
            'filtros' => FiltroProducto::lista()
        ]);
    }

    // Guardar
    public function guardar(Request $rq){

        // Validación
        $rq->validate([
            'titulo'    => 'required|string|unique:' . (new FiltroProducto)->getTable() . ',titulo,' . $rq->id . '|between:1,50|',
            'opciones'  => 'sometimes|array|required'
        ]);

        // Registro
        if (!$reg = FiltroProducto::find($rq->id)) {
            $reg = new FiltroProducto;
        }
        $reg->titulo = $rq->titulo;
        $reg->save();

        // Opciones
        // Actualizo
        foreach (FiltroProducto::where('relacion', $reg->id)->get(['id']) as $opcion) {
            if ( isset( $rq->opciones[$opcion->id] ) ) {
                $opcion->titulo = $rq->opciones[$opcion->id];
                $opcion->save();
            }
            else {
                $opcion->delete();
            }
        }
        // Nuevas
        if (isset($rq->opciones['nuevas'])) {
            foreach ($rq->opciones['nuevas'] as $id => $o) {
                $opcion = new FiltroProducto;
                $opcion->titulo = $o;
                $opcion->relacion = $reg->id;
                $opcion->save();
            }
        }

        // Respuesta
        return back()->with([
            'alerta' => [
                'tipo' => 'success'
            ]
        ]);
    }

    // Eliminar
    public function eliminar(Request $rq){

        // Filtros
        FiltroProducto::whereIn('id', $rq->registros)->delete();

        // Posibles opciones relacionadas
        FiltroProducto::whereIn('relacion', $rq->registros)->delete();
        
        // Respuesta
        return back()->with([
            'alerta' => [
                'tipo' => 'success'
            ]
        ]);
    }
}
