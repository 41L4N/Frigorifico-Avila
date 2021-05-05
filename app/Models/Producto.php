<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FiltroProducto;

class Producto extends Model
{
    use HasFactory;

    // Alias
    function alias(){
        return formatos('tb', "$this->titulo " . $this->filtroP(), '-');
    }

    // Filtro
    public function filtroP(){
        if ($f = FiltroProducto::find($this->filtro)) {
            if ($f->relacion) {
                if ($r = FiltroProducto::find($f->relacion)) {
                    return $f = "$r->titulo ($f->titulo)";
                }
            }
            return $f->titulo;
        }
        return null;
    }

    // Precio y oferta
    function precioOfertaP(){
        return [
            'precio' => formatos('n', $p = $this->precio_detal, true),
            'oferta' => formatos('n', ($p - $this->oferta * $p / 100), true) . " (-$this->oferta %)"
        ];
        return $r;
    }

    // Precio al mayor
    function precioMayorP(){
        $r = formatos('n', $this->precio_mayor, true) . " (x $this->pedido_min_mayor $this->unidad_medida)";
        return $r;
    }
}