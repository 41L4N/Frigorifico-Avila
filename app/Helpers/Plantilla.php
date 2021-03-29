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
function formatos($tipo,$dato,$texto=null){
    switch ($tipo) {

        // Fecha
        case 'f':
            
        break;
    
        // Numérico
        case 'n':
            
        break;
    
        // Telefonico
        case 't':
            $r = implode(' ', json_decode($dato, true));
            $r = ($texto) ? "+$r" : $r;
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
        'success'       =>  "fas fa-check",
        'danger'        =>  "fas fa-times",

        // Enlaces
        'roles'         =>  "fas fa-user-lock",
        'usuarios'      =>  "fas fa-users",
        'inventario'    =>  "fas fa-boxes"
    ];

    // Respuesta
    return ( isset( $iconos[$i] ) ) ? $iconos[$i] : null;
}