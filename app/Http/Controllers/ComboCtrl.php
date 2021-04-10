<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Combo;

class ComboCtrl extends Controller
{
    // Registros
    public function registros(){
        return view('combos')->with([
            'combos' => Combo::all()
        ]);
    }
}