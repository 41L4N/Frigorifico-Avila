<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Models\FiltroProducto;
use App\Models\Producto;
use App\Models\Combo;

class ProductoCtrl extends Controller
{

    // Registros
    public function registros(){
        return view('productos.inventario')->with([
            'filtros'   => FiltroProducto::lista(),
            'productos' => Producto::all()
        ]);
    }

    // Guardar
    public function guardar(Request $rq){

        // Validación
        $rq->validate([
            'titulo'            => 'required|between:1,75',
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
        if (!$reg = Producto::find($rq->id)) {
            $reg = new Producto;
        }
        // Campos directos
        foreach (Schema::getColumnListing( (new Producto)->getTable() ) as $campo) {
            if ($rq->exists($campo)) {
                $reg->$campo = $rq->$campo;
            }
        }
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

        // Imágenes relacionadas
        foreach ($rq->registros as $id) {
            if (almacenImgs()->exists($ruta = (new Producto)->getTable() . "_$id.json")) {
                almacenImgs()->delete($ruta);
            }
        }

        // Registros
        Producto::whereIn('id', $rq->registros)->delete();

        // Respuesta
        return back()->with([
            'alerta' => [
                'tipo' => 'success'
            ]
        ]);
    }

    // Productos
    public function productos($filtro=null, $id=null, $id2=null){

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

            // Filtros
            case 'filtros':
                $ps = Producto::where('filtro', $id2);
            break;

            // Ofertas
            case 'ofertas':
                $ps = Producto::where('oferta', '>', 0);
            break;

            // Sin coincidencia
            default:
                return redirect()->route('productos');
            break;
        }

        // Respuesta
        return view('productos.productos')->with([
            'productos' => $ps->orderBy('titulo', 'ASC')->get()
        ]);
    }
}