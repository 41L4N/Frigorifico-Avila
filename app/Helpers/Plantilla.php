<?php

// Prefijo
function prefijo(){
    $prefijo = explode( "/", Request::route()->getPrefix() );
    return end($prefijo);
}

// Formatos
function formatos($tipo){
    switch ($tipo) {

        // Fecha
        case 'f':
            
        break;
    
        // Numérico
        case 'n':
            
        break;
    
        // Telefonico
        case 't':
            
        break;
    }
}

// Iconos
function iconos($i){

    // Iconos
    $iconos =  [

        // Alertas
        'success'   =>  "fas fa-check",
        'danger'    =>  "fas fa-times",

        // Enlaces
        'roles'     =>  "fas fa-user-lock",
        'usuarios'  =>  "fas fa-users"
    ];

    // Respuesta
    return ( isset( $iconos[$i] ) ) ? $iconos[$i] : null;
}