<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class OrdenCompraCtrl extends Controller
{

    // Lista de compras
    public function listaCompras(Request $rq){

        // Validación
        $rq->validate([
            'accion'        => 'required|digits:1|digits_between:0,2',
            'id_producto'   => 'required|integer',
            'cantidad'      => 'required|digits_between:1,5|min:1',
        ]);

        // Lista de compras
        if (!$listaCompras = Cache::get($n='lista-compras')) {
            $listaCompras = [];
        }

        // Compra actual
        $compra = array_filter($listaCompras, function ($c) use ($rq) {
            return ($c['id_producto'] == $rq->id_producto);
        });
        $iC = array_key_first($compra);

        // Acción
        switch ($rq->accion) {
            // Agregar
            case 0:
                // Nuevo producto
                if ($iC !== null) {
                    $compra[$iC]['cantidad'] = $compra[$iC]['cantidad'] + $rq->cantidad;
                    $listaCompras[$iC] = $compra[$iC];
                }
                // O sumar cantidades
                else {
                    array_push($listaCompras, [
                        'id_producto'   => $rq->id_producto,
                        'cantidad'      => $rq->cantidad
                    ]);
                }
            break;
            // Editar
            case 1:
                if ($iC !== null) {
                    $listaCompras[$iC]['cantidad'] = $rq->cantidad;
                }
            break;
            // Eliminar
            case 2:
                if ($iC !== null) {
                    unset($listaCompras[$iC]);
                }
            break;
        }
        Cache::put($n, $listaCompras);

        // Respuesta
        if ($rq->ajax()) {
            return true;
        }
        else {
            return back()->with([
                'alerta'    => [
                    'tipo' => 'success'
                ]
            ]);
        }
    }

    // Orden
    public function ordenCompra(Request $rq){


    }

    // Confirmar

    // Verificar
}