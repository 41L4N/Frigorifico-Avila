<?php

// Iconos
function iconos($i){
    $iconos =  [

        // Alertas
        'success'   =>  "fas fa-check",
        'danger'    =>  "fas fa-times",
    ];

    return ( isset( $iconos[$i] ) ) ? $iconos[$i] : null;
}