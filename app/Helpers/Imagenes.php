<?php

function almacenImg(){
    return Storage::disk('public');
}

// Convertir imagen a base64 y bajarles el peso
function convertirImg($tipo, $img, $resolucion=null){

    // Contenido original
    // Imágen
    $imgO = imagecreatefromstring( (gettype($img) == 'string') ? base64_decode($img) : file_get_contents($img) );

    // Tamaños
    $anchoO = imagesx($imgO);
    $altoO = imagesy($imgO);

    // Relación de aspecto - Alto y ancho
    $relacionAspecto = ($resolucion) ? $resolucion : [
        'carrusel'  => 1500,
        "productos" => 500
    ][$tipo];

    // Relación de aspecto
    $relacionAspecto = min(
        // Alto
        $relacionAspecto / $altoO,
        // Ancho
        $relacionAspecto / $anchoO
    );

    // Nuevos tamaños
    $anchoN = $anchoO * $relacionAspecto;
    $altoN = $altoO * $relacionAspecto;

    // Nueva imagen
    $nuevaImg = imageCreateTrueColor($anchoN, $altoN);

    // Transparencia
    imagealphablending($nuevaImg, false);
    imagecopyresampled($nuevaImg, $imgO, 0, 0, 0, 0, $anchoN, $altoN, $anchoO, $altoO);

    // Orientación
    $or = @exif_read_data($img);
    if ( isset($or["Orientation"]) ) {
        $nuevaImg = imagerotate($nuevaImg, [1=>0, 3=>180, 6=>-90, 8=>90][$or["Orientation"]], 0);
    }

    // Convertir a base64
    ob_start();
    imagewebp($nuevaImg, null, 100);
    $base64 = base64_encode(ob_get_clean());
    imagedestroy($nuevaImg);

    // Respuesta
    return $base64;
}

// Guardar
function guardarImg($tipo, $img, $id){
    if ($base64 = convertirImg($tipo, $img)) {
        $ruta = $tipo."_$id.json";
        almacenImg()->put($ruta, $base64);
    }
}

// Mostrar
function mostrarImg($tipo, $id, $iImg=0, $resolucion=null){
    header('Content-Type: image/webp;');
    header('Content-Disposition: inline; filename="'.$id.$iImg.'.webp"');
    $base64 = almacenImg()->get($tipo."_$id.json");
    if ($resolucion) {
        $base64 = convertirImg($tipo, $base64, $resolucion);
    }
    echo( base64_decode($base64) );
}