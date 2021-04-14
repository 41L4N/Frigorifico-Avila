<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Models\Producto;
use App\Models\Combo;

class ComboCtrl extends Controller
{
    // Registros
    public function registros(){
        return view('combos')->with([
            'combos'    => Combo::all()->map(function($c){
                $c->datos_productos = Producto::whereIn('id',
                    array_map(function ($p){
                        return $p['id'];
                    }, json_decode($c->productos, true))
                )->get(['id', 'titulo']);
                return $c;
            }),
            'productos' => Producto::get(['id', 'titulo'])
        ]);
    }

    // Guardar
    public function guardar(Request $rq){

        // Validación
        $rq->validate([
            'id'        => 'nullable|numeric|integer',
            'titulo'    => 'required|unique:' . (new Combo)->getTable() . ',titulo,' . $rq->id . '|between:1,75',
            'precio'    => 'required|digits_between:1,5',
            'productos' => 'required|array',
            'img'       => 'nullable|file|image|mimes:jpg,jpeg,png',
        ]);

        // Registro
        if (!$reg = Combo::find($rq->id)) {
            $reg = new Combo;
        }
        // Campos directos
        foreach (Schema::getColumnListing( (new Combo)->getTable() ) as $campo) {
            if ($rq->exists($campo)) {
                $reg->$campo = $rq->$campo;
            }
        }
        // Campos adicionales
        $reg->productos = json_encode(array_values($rq->productos));

        // Guardar
        $reg->save();

        // Campos adicionales
        // Imagen
        if ($rq->img) {
            guardarImg($reg->getTable(), $rq->img, $reg->id);
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

        // Registros
        Combo::whereIn('id', $rq->registros)->delete();
        
        // Respuesta
        return back()->with([
            'alerta' => [
                'tipo' => 'success'
            ]
        ]);
    }

    // Combos
    public function combos($alias=null, $id=null){

        // Combo individual
        if ($p = Combo::find($id)) {
            return view('productos.producto')->with([
                'producto' => $p
            ]);
        }

        // Todos
        else {
            return view('productos.productos')->with([
                'productos' => Combo::orderBy('titulo', 'ASC')->get()
            ]);
        }
    }
}