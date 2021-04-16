<?php

// Formatos
function formatos($tipo,$dato,$parametroAdicional=null){
    switch ($tipo) {

        // Texto base
        case 'tb':
            $r = strtolower(
                str_replace(
                    " ",
                    $parametroAdicional,
                    preg_replace('([^A-Za-zñÑ0-9 ])','',iconv('UTF-8','ASCII//TRANSLIT',$dato))
                )
            );
        break;

        // Fecha
        case 'f':
            $r = date('d-m-Y', strtotime($dato));
        break;

        // Numérico
        case 'n':
            $r = (($parametroAdicional) ? "$" : "") . number_format($dato, 2, ',', '.');
        break;

        // Telefonico
        case 't':
            $r = (($parametroAdicional) ? "+" : "") .  implode(' ', json_decode($dato, true));
        break;
    }

    // Respuesta 
    return $r;
}

// Iconos
function iconos($i){

    // Iconos
    $iconos =  [

        // Alertas
        'success'           => "fas fa-check",
        'danger'            => "fas fa-times",

        // Enlaces
        'carrusel'          => "fas fa-images",
        'roles'             => "fas fa-user-lock",
        'usuarios'          => "fas fa-users",
        'filtros-productos' => "fas fa-filter",
        'productos'         => "fas fa-boxes",
        'combos'            => "fas fa-gifts",
        'cupones'           => "fas fa-money-check-alt"
    ];

    // Respuesta
    return ( isset( $iconos[$i] ) ) ? $iconos[$i] : null;
}

// Lista de compras
function listaCompras(){
    $listasCompras = ($lC = Cache::get('listas-compras')) ? $lC : [];
    $listaCompras = null;
    foreach ($listasCompras as $lC) {
        if ($lC['ip'] == request()->ip() || ((Auth::check()) ? $lC['id_usuario'] == Auth::user()->id : null)) {
            $listaCompras = $lC;
        }
    }

    // Lista productos en cache
    $total = 0;
    $nCompras = 0;
    foreach ( isset($listaCompras['productos']) ? $listaCompras['productos'] : [] as $iP => $p ) {

        // Producto
        // Si el producto no existe entonces se borra de la lista
        if (!$c = DB::table($p['tipo'])->find($p['id'])) {
            unset($listaCompras['productos'][$iC]);
            continue;
        }

        // Tipo
        $c->tipo = $p['tipo'];

        // Alias
        $c->alias = $c->titulo; 

        // Precio de venta según cantidad y oferta
        $c->cantidad = $p['cantidad'];
        $c->precio_unitario = ($c->precio_mayor && $c->cantidad >= $c->pedido_min_mayor) ? $c->precio_mayor : ($precioD = $c->precio_detal) - $c->oferta * $precioD / 100;
        $c->precio_unitario_p = formatos('n', $c->precio_unitario, true);

        // Subtotal
        $subtotal = $c->precio_unitario * $c->cantidad;
        $c->subtotal = formatos('n', $subtotal, true);

        // Producto
        $listaCompras['productos'][$iP] = $c;

        // Total
        $total = $total + $subtotal;
        
        // Número de compras
        $nCompras = $nCompras + $c->cantidad;
    }

    // Total
    $listaCompras['total'] = formatos('n', $total ,true);

    // Número de compras
    $listaCompras['nCompras'] = $nCompras;

    // Respuesta
    return $listaCompras;
}