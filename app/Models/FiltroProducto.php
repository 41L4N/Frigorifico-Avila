<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiltroProducto extends Model
{
    use HasFactory;

    protected $table = 'filtros_productos';

    // Alias
    function alias(){
        return formatos('tb', $this->titulo, '-');
    }

    // Lista
    static function lista(){
        foreach ($filtros = FiltroProducto::whereNull('relacion')->orderBy('titulo', 'ASC')->get(['id', 'titulo']) as $f) {
            $f->opciones = FiltroProducto::where('relacion', $f->id)->orderBy('titulo', 'ASC')->get(['id','titulo']);
        }
        return $filtros;
    }
}