<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\FiltroProducto;

class FiltroProductoCtrl extends Controller
{
    // Filtros
    public function filtros(){

        foreach ($filtros = FiltroProducto::whereNull('relacion')->get(['id', 'titulo']) as $f) {
            $f->opciones = FiltroProducto::where('relacion', $f->id)->get(['id','titulo']);
        }
        return view('productos.filtros')->with([
            'filtros' => $filtros
        ]);
    }

    // Guardar
    public function guardar(Request $rq){

        // Validación
        $rq->validate([
            'titulo'    => 'required|max:75|'.Rule::unique( (new FiltroProducto)->getTable() )->ignore($rq->id),
            'opcion'    => 'sometimes|required'
        ]);

        // Registro
        if (!$fp = FiltroProducto::find($rq->id)) {
            $fp = new FiltroProducto;
        }
        $fp->titulo = $rq->titulo;
        $fp->save();

        // Posibles opciones
        if ($rq->opcion) {
            foreach ($rq->opcion as $id => $o) {
                if (!$opcion = FiltroProducto::find($id)) {
                    $opcion = new FiltroProducto;
                }
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
