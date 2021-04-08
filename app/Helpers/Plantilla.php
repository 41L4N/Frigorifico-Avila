<?php

// Prefijo
function prefijo($espacio=null){
    $prefijo = explode("/", Request::route()->getPrefix());
    if ($espacio) {
        $prefijo = str_replace('-', $espacio, $prefijo);
    }
    return end($prefijo);
}

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
        'inventario'        => "fas fa-boxes",
        'cupones'           => "fas fa-ticket-alt"
    ];

    // Respuesta
    return ( isset( $iconos[$i] ) ) ? $iconos[$i] : null;
}