<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Inicio
Route::get('/',[InicioCtrl::class,'inicio'])->name("inicio");

// Rutas protegidas
Route::group(['middleware'=>'auth'],function(){

    // Validación de administrador
    if ( Auth::check() && !Auth::user()->administrador ) {
        back();
    }

    // Inventario

    // Ordenes de compra

    // Ofertas

    // Combos

    // Salir
    Route::get("/salir",function (){
        Auth::logout();
        return redirect("inicio");
    });
});