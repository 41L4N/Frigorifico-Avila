<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FiltroProducto;

class FiltroProductoCtrl extends Controller
{
    // Filtros
    public function filtros(){
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
        if (!$fp = FiltroProducto::find($rq->id)) {
            $fp = new FiltroProducto;
        }
        $fp->titulo = $rq->titulo;
        $fp->save();

        // Opciones
        // Actualizo
        foreach (FiltroProducto::where('relacion', $fp->id)->get(['id']) as $opcion) {
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
                $opcion->relacion = $fp->id;
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
        foreach ($rq->resultado as $id) {
            // Posibles opciones
            FiltroProducto::where('relacion', $id)->delete();
            FiltroProducto::find($id)->delete();
        }
        // Respuesta
        return back()->with([
            'alerta' => [
                'tipo' => 'success'
            ]
        ]);
    }
}
