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
        'ordenes-compras'   => "fas fa-clipboard-list",

        // Contactos
        'whatsapp'          => "fab fa-whatsapp",

        // Redes sociales
        'facebook'          => "fab fa-facebook-f",
        'twitter'           => "fab fa-twitter",
        'instagram'         => "fab fa-instagram",

        // Envíos
        'envios'            => "fas fa-truck"
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

    // Número de compras
    $nCompras = 0;
    foreach ( isset($listaActual['productos']) ? $listaActual['productos'] : [] as $iP => $p ) {

        // Producto
        // Si el producto no existe entonces se borra de la lista
        if (!$c = DB::table($p['tipo'])->find($p['id'])) {
            unset($listaActual['productos'][$iP]);
            $listaActual['productos'] = array_values($listaActual['productos']);
            continue;
        }

        $nCompras = $nCompras + $p['cantidad'];
    }
    // Número de compras
    $listaActual['nCompras'] = $nCompras;

    // Alerta
    $listaActual['msjAlerta'] = __('textos.alertas.compras_' . (($nCompras < 20) ? "minoristas" : "mayoristas") );

    // Lista productos en cache
    $total = 0;
    foreach ( isset($listaActual['productos']) ? $listaActual['productos'] : [] as $iP => $p ) {

        // Producto
        // Si el producto no existe entonces se borra de la lista
        if (!$c = DB::table($p['tipo'])->find($p['id'])) {
            unset($listaActual['productos'][$iP]);
            $listaActual['productos'] = array_values($listaActual['productos']);
            continue;
        }

        // Tipo
        $c->tipo = $p['tipo'];

        // Alias
        $c->alias = $c->titulo;

        // Cantidad
        $c->cantidad = $p['cantidad'];
        if ($c->tipo == 'productos') {
            // Oferta
            $c->precio_unitario = ($c->oferta && $c->cantidad >= $c->pedido_min_oferta) ? $c->precio_minorista - ($c->oferta * $c->precio_minorista / 100) : $c->precio_minorista;
            // Precio al mayor
            $c->precio_unitario = ($listaActual['nCompras'] >= 20 && $c->precio_mayorista) ? $c->precio_mayorista : $c->precio_unitario;
        }
        else {
            $c->precio_unitario = $c->precio;
        }

        // Precio unitario público
        $c->precio_unitario_p = formatos('n', $c->precio_unitario, true);
        // Subtotal
        $subtotal = $c->precio_unitario * $c->cantidad;
        $c->subtotal = formatos('n', $subtotal, true);

        // Producto
        $listaActual['productos'][$iP] = $c;

        // Total
        $total = $total + $subtotal;
    }

    // Total
    $listaActual['total'] = [
        'texto'     => formatos('n', $total ,true),
        'numero'    => $total
    ];

    // Respuesta
    return [
        'i'     => $iListaActual,
        'lista' => $listaActual
    ];
}