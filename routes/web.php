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

// Acceso
// Perfil web
Route::prefix('')->group(function(){

    // Validación si ya existe usuario
    if(Auth::check()){
        return redirect()->route('usuario');
    }

    // Vista de sesión
    Route::view('/{seccion}','usuarios.sesion')
    ->where('seccion','(registro|ingreso|recuperar-clave|renovar-clave)')
    ->name('sesion');

    // Registro
    Route::post('/registro',[UsuarioCtrl::class,'guardar']);
    // Ingreso
    Route::post('/ingreso',[UsuarioCtrl::class,'ingresar']);
    // Recuperar clave
    Route::post('/recuperar-clave',[UsuarioCtrl::class,'recuperarClave'])->name('recuperar-clave');
    // Renovar clave
    Route::post('/renovar-clave',[UsuarioCtrl::class,'renovarClave']);
});

// Productos
Route::get('/productos/{seo?}/{codigo?}',[ProductoCtrl::class,'inicio'])->name('productos');

// Rutas protegidas
Route::group(['middleware'=>'auth'],function(){

    // Usuario
    Route::prefix($n='usuario')->name($n)->group(function(){

        // Perfil
        Route::get('/',[UsuarioCtrl::class,'perfil'])->name('');

        // Salir
        Route::get("/salir",function (){
            Auth::logout();
            return redirect("inicio");
        })->name('salir');
    });

    // Administrador
    Route::prefix('administrador')->group(function(){

        // Validación de administrador
        if ( Auth::check() && !Auth::user()->administrador ) {
            back();
        }
    
        // Inventario
    
        // Ordenes de compra
    
        // Ofertas
    
        // Combos
    });
});