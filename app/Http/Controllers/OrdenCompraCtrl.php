<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Models\OrdenCompra;

class OrdenCompraCtrl extends Controller
{

    // Registros
    public function registros($id=null){

        // Vista en PDF
        if ($id) {
            return "";
        }

        // Lista de registros
        return view('ordenes-compras.ordenes-compras')->with([
            'ordenesCompras' => OrdenCompra::all()
        ]);
    }

    // Lista de compras
    public function lista(Request $rq){

        // Validación
        $rq->validate([
            'accion'        => 'required|digits:1|digits_between:0,2',
            'tipo'          => 'required|string',
            'id'            => 'required|integer',
            'cantidad'      => 'required|digits_between:1,5|min:1',
        ]);

        // Lista actual
        $listas = ($lC = Cache::get($nombreCache = 'listas-compras')) ? $lC : [];
        $iListaActual = listaCompras()['i'];

        // Producto actual
        $iProductoActual = null;
        if ($iListaActual !== null) {
            foreach ($listas[$iListaActual]['productos'] as $iC => $c) {
                if ($c['tipo'] == $rq->tipo && $c['id'] == $rq->id) {
                    $iProductoActual = $iC;
                }
            }
        }

        // Acción
        switch ($rq->accion) {
            // Agregar
            case 0:

                // Nueva lista
                if ($iListaActual === null) {
                    array_push($listas, [
                        'ip'            => request()->ip(),
                        'id_usuario'    => (Auth::check()) ? Auth::user()->id : null,
                        'productos'     => []
                    ]);
                    $iListaActual = array_key_last($listas);
                }

                // Nuevo producto
                if ($iProductoActual === null) {
                    array_push($listas[$iListaActual]['productos'], [
                        'tipo'      => $rq->tipo,
                        'id'        => $rq->id,
                        'cantidad'  => $rq->cantidad
                    ]);
                    $iProductoActual = array_key_last($listas[$iListaActual]['productos']);
                }
                // O sumar cantidades
                else {
                    $cantidad = $listas[$iListaActual]['productos'][$iProductoActual]['cantidad'];
                    $listas[$iListaActual]['productos'][$iProductoActual]['cantidad'] = $cantidad + $rq->cantidad;
                }
            break;
            // Editar
            case 1:
                if ($iProductoActual !== null) {
                    $listas[$iListaActual]['productos'][$iProductoActual]['cantidad'] = $rq->cantidad;
                }
            break;
            // Eliminar
            case 2:
                if ($iProductoActual !== null) {
                    unset($listas[$iListaActual]['productos'][$iProductoActual]);
                }
            break;
        }
        Cache::put($nombreCache, $listas);

        // Respuesta
        return response( listaCompras()['lista'] );
    }

    // Orden
    public function orden(Request $rq){

        // Validación
        $rq->validate([
            'cantidad'          => 'required|digits_between:1,5|min:1',
            'datos_facturacion' => "sometimes|array",
            'direccion_envio'   => "sometimes|array",
            'notas'             => "nullable",
            // 'cupon'             => "nullable|exists:cupones,codigo"
        ]);

        // Lista
        $listaActual = listaCompras(true);

        // Registro
        $reg = new OrdenCompra;
        $reg->id_usuario = Auth::user()->id;
        $reg->codigo = uniqid();
        $reg->datos_facturacion = ($dF = $rq->datos_facturacion) ? json_encode($dF) : null;
        $reg->direccion_envio = ($dE = $rq->direccion_envio) ? json_encode($dE) : null;
        $reg->productos = json_encode($listaActual['lista']['productos']);
        $reg->total = $listaActual['lista']['total']['numero'];
        $reg->save();

        // Notificación
        Mail::send("correos.orden-compra", [
            'asunto'        => $asunto = __('textos.titulos.nueva_orden_compra'),
            'usuario'       => Auth::user(),
            'ordenCompra'   => $reg
        ], function($m) use ($rq, $asunto){
            $m->to("jeka.gomezb@gmail.com");
            $m->subject($asunto);
        });

        // Respuesta
        return back()->with([
            'alerta' => [
                'tipo'  => 'success',
                'texto' => __('textos.alertas.orden_compra')
            ]
        ]);
    }

    // Confirmar

    // Verificar
}