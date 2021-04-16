<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class OrdenCompraCtrl extends Controller
{

    // Lista de compras
    public function lista(Request $rq){

        // Validación
        $rq->validate([
            'accion'        => 'required|digits:1|digits_between:0,2',
            'tipo'          => 'required|string',
            'id'            => 'required|integer',
            'cantidad'      => 'required|digits_between:1,5|min:1',
        ]);

        // Cache::put('listas-compras',
        //     [
        //         [
        //             'ip'         => '127.0.0.1',
        //             'id_usuario' => 1,
        //             'productos'    => []
        //         ],
        //     ]
        // );

        // Cache::pull('listas-compras');

        // Todas las Lista
        $listasCompras = ($lC = Cache::get($n='listas-compras')) ? $lC : [];

        // Lista actual
        $iListaActual = null;
        foreach ($listasCompras as $iLC => $lC) {
            if ($lC['ip'] == request()->ip() || ((Auth::check()) ? $lC['id_usuario'] == Auth::user()->id : null)) {
                $iListaActual = $iLC;
            }
        }

        // Actualizar id de usuario
        if ($iListaActual !== null && Auth::check() && !$listasCompras[$iListaActual]['id_usuario']) {
            $listasCompras[$iListaActual]['id_usuario'] = Auth::user()->id;
        }

        // Producto actual
        $iProductoActual = null;
        if ($iListaActual !== null) {
            foreach ($listasCompras[$iListaActual]['productos'] as $iC => $c) {
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
                    array_push($listasCompras, [
                        'ip'            => request()->ip(),
                        'id_usuario'    => (Auth::check()) ? Auth::user()->id : null,
                        'productos'     => []
                    ]);
                    $iListaActual = array_key_last($listasCompras);
                }

                // Nuevo producto
                if ($iProductoActual === null) {
                    array_push($listasCompras[$iListaActual]['productos'], [
                        'tipo'      => $rq->tipo,
                        'id'        => $rq->id,
                        'cantidad'  => $rq->cantidad
                    ]);
                    $iProductoActual = array_key_last($listasCompras[$iListaActual]['productos']);
                }
                // O sumar cantidades
                else {
                    $cantidad = $listasCompras[$iListaActual]['productos'][$iProductoActual]['cantidad'];
                    $listasCompras[$iListaActual]['productos'][$iProductoActual]['cantidad'] = $cantidad + $rq->cantidad;
                }
            break;
            // Editar
            case 1:
                if ($iProductoActual !== null) {
                    $listasCompras[$iListaActual]['productos'][$iProductoActual]['cantidad'] = $rq->cantidad;
                }
            break;
            // Eliminar
            case 2:
                if ($iProductoActual !== null) {
                    unset($listasCompras[$iListaActual]['productos'][$iProductoActual]);
                }
            break;
        }
        Cache::put($n, $listasCompras);

        // Respuesta
        return response( listaCompras() );
    }

    // Orden
    public function orden(Request $rq){
        dd($rq);
    }

    // Confirmar

    // Verificar
}