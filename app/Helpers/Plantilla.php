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
        'cupones'           => "fas fa-money-check-alt",

        // Redes sociales
        'facebook'          => "fab fa-facebook-f"
    ];

    // Respuesta
    return ( isset( $iconos[$i] ) ) ? $iconos[$i] : null;
}

// Lista de compras
function listaCompras($actualizarId=false){
    $listas = ($lC = Cache::get($nombreCache = 'listas-compras')) ? $lC : [];
    $listaActual = null;
    $iListaActual = null;
    foreach ($listas as $iLC => $lC) {
        if (
            ((Auth::check()) ? $lC['id_usuario'] == Auth::user()->id || $lC['ip'] == request()->ip() && !$lC['id_usuario'] : null)
            ||
            ((!Auth::check()) ? $lC['ip'] == request()->ip() && !$lC['id_usuario'] : null)
        ) {
            $iListaActual = $iLC;
            $listaActual = $lC;
        }
    }

    // Actualizar id de usuario
    if ($actualizarId && $iListaActual !== null && Auth::check() && !$listas[$iListaActual]['id_usuario']) {
        $listas[$iListaActual]['id_usuario'] = Auth::user()->id;
        Cache::put($nombreCache, $listas);
        $listaActual = $listas[$iListaActual];
    }

    // Lista productos en cache
    $total = 0;
    $nCompras = 0;
    foreach ( isset($listaActual['productos']) ? $listaActual['productos'] : [] as $iP => $p ) {

        // Producto
        // Si el producto no existe entonces se borra de la lista
        if (!$c = DB::table($p['tipo'])->find($p['id'])) {
            unset($listaActual['productos'][$iC]);
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
        $listaActual['productos'][$iP] = $c;

        // Total
        $total = $total + $subtotal;
        
        // Número de compras
        $nCompras = $nCompras + $c->cantidad;
    }

    // Total
    $listaActual['total'] = formatos('n', $total ,true);

    // Número de compras
    $listaActual['nCompras'] = $nCompras;

    // Respuesta
    return [
        'i'     => $iListaActual,
        'lista' => $listaActual
    ];
}