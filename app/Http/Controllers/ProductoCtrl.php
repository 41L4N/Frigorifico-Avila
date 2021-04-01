<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Models\Producto;
use App\Models\FiltroProducto;

class ProductoCtrl extends Controller
{

    // Inventario
    public function inventario(){
        return view('productos.inventario')->with([
            'filtros'   => FiltroProducto::lista(),
            'productos' => Producto::all()
        ]);
    }

    // Guardar
    public function guardar(Request $rq){

        // Validación
        $rq->validate([
            'titulo'            => 'required|between:1,50',
            'filtro'            => 'required|integer',
            'pedido_min_detal'  => 'required|digits_between:1,5',
            'precio_detal'      => 'required|digits_between:1,5',
            'oferta'            => 'nullable|digits_between:1,5',
            'pedido_min_mayor'  => 'nullable|digits_between:1,5',
            'precio_mayor'      => 'nullable|digits_between:1,5',
            'descripcion'       => 'nullable|max:500',
            'img'               => 'nullable|file|image|mimes:jpg,jpeg,png',
        ]);

        // Registro
        if (!$p = Producto::find($rq->id)) {
            $p = new Producto;
        }
        // Campos directos
        foreach (Schema::getColumnListing( (new Producto)->getTable() ) as $campo) {
            if ($rq->exists($campo)) {
                $p->$campo = $rq->$campo;
            }
        }
        // Guardar
        $p->save();

        // Campos adicionales
        // Imagen
        if ($rq->img) {
            guardarImg((new Producto)->getTable(), $rq->img, $p->id);
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
        foreach ($rq->resultados as $id) {
            if (almacenImg()->exists($ruta = (new Producto)->getTable() . "_$i.json")) {
                almacenImg()->delete($ruta);
            }
            Producto::find($id)->delete();
        }
        // Respuesta
        return back()->with([
            'alerta' => [
                'tipo' => 'success'
            ]
        ]);
    }

    // Productos

    // Producto
}