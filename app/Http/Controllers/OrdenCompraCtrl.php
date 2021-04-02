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
            'id'        => 'required|integer',
            'cantidad'  => 'required|digits_between:1,5'
        ]);

        // Registro
        if (!$listaCompras = Cache::get($n='lista-compras')) {
            $listaCompras = [];
        }
        array_push($listaCompras, [
            'id'        => $rq->id,
            'cantidad'  => $rq->cantidad
        ]);
        Cache::put($n, $listaCompras);

        // Respuesta
        return back()->with([
            'alerta'    => [
                'tipo' => 'success'
            ]
        ]);
    }

    // Orden
    public function ordenCompra(Request $rq){

        // Actualizar listado
        if ($rq->method() == "POST") {
            $listaCompras = [];
            foreach ($rq->ids as $i => $id) {
                array_push($listaCompras, [
                    'id'        => $rq->ids[$i],
                    'cantidad'  => $rq->cantidades[$i]
                ]);
            }
            Cache::put('lista-compras', $listaCompras);
        }

        // Respuesta
        return view('orden-compra');
    }

    // Confirmar

    // Verificar
}