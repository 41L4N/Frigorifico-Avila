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
            'unidad_medida'     => 'required',
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
            if (almacenImg()->exists($ruta = (new Producto)->getTable() . "_$id.json")) {
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
    public function productos($filtro=null, $id=null){

        // Producto individual
        if ($p = Producto::find($id)) {
            $p->n_visitas = $p->n_visitas + 1;
            $p->save();
            return view('productos.producto')->with([
                'producto'  => $p
            ]);
        }

        // Según el filtro
        switch ($filtro){

            // Todos
            case null:
                $ps = Producto::select("*");
            break;

            // Buscador
            case 'buscar':

                // Titulo
                if($rq->consulta != ""){
                    $ps = Producto::where("titulo","LIKE","%$rq->consulta%");
                }
                // Precio
            break;

            // Ofertas
            case 'ofertas':
                
            break;
        }

        // Respuesta
        return view('productos.productos')->with([
            'productos' => $ps->orderBy('titulo', 'ASC')->get()
        ]);
    }
}