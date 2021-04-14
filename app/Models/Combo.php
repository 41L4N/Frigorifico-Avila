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
}