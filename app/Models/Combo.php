<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Combo extends Model
{
    use HasFactory;

    // Alias
    function alias(){
        return formatos('tb', $this->titulo, '-');
    }

    // Precio y oferta
    function precioOfertaP(){
        return [
            'precio' => formatos('n', $p = $this->precio, true),
            'oferta' => formatos('n', round($p - $this->oferta * $p / 100), true) . " (-$this->oferta %)"
        ];
        return $r;
    }
}