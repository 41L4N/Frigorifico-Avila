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

// Mostrar imagen
Route::get('/img/{tipo}/{id}/{iImg?}/{resolucion?}',function($tipo, $id, $iImg=0, $resolucion=null){
    mostrarImg($tipo, $id, $iImg, $resolucion);
})->name('mostrar-img');

// Inicio
Route::get('/', [InicioCtrl::class,'inicio'])->name("inicio");

// Sesion
Route::get('/{seccion}/{codigo_acceso?}', [UsuarioCtrl::class,'sesion'])
->where('seccion', '(registro|ingreso|recuperacion-contraseña|renovacion-contraseña)')
->name('sesion');
// Registro
Route::post('/registro', [UsuarioCtrl::class,'guardar']);
// Ingreso
Route::post('/ingreso', [UsuarioCtrl::class,'ingreso']);
// Recuperación de contraseña
Route::post('/recuperacion-contraseña', [UsuarioCtrl::class,'recuperacionContraseña'])->name('sesion-recuperacion-contraseña');
// Renovación de contraseña
Route::post('/renovacion-contraseña', [UsuarioCtrl::class,'renovacionContraseña']);

// Productos
Route::get('/productos/{filtro?}/{id?}', [ProductoCtrl::class,'productos'])->name('productos');
Route::post('/lista-compras', [OrdenCompraCtrl::class,'listaCompras'])->name('lista-compras');
Route::view('/orden-compra', 'orden-compra')->name('orden-compra');

// Rutas protegidas
Route::middleware('auth')->group(function(){

    // Usuario
    Route::prefix($n='usuario')->name($n)->group(function(){

        // Perfil
        Route::get('/', [UsuarioCtrl::class,'usuario'])->name('-perfil');

        // Salir
        Route::get("/salir", function (){
            Auth::logout();
            return redirect()->route("inicio");
        })->name('-salir');
    });

    // Administrador
    Route::prefix($n='panel-administrador')->middleware('permisos')->group(function(){

        // Panel de administrador
        Route::view('/','panel-administrador')->name('panel-administrador');

        // Roles
        Route::prefix($n='roles')->name($n)->group(function (){
            Route::get('/', [RolesCtrl::class,'roles'])->name('');
            Route::post('/', [RolesCtrl::class,'guardar']);
            Route::post('/eliminar', [RolesCtrl::class,'eliminar'])->name('-eliminar');
        });

        // Usuarios
        Route::prefix($n='usuarios')->name($n)->group(function (){
            Route::get('/', [UsuarioCtrl::class,'usuarios'])->name('');
            Route::post('/', [UsuarioCtrl::class,'guardar']);
            Route::post('/eliminar', [UsuarioCtrl::class,'eliminar'])->name('-eliminar');
        });

        // Filtros
        Route::prefix($n='filtros-productos')->name($n)->group(function (){
            Route::get('/', [FiltroProductoCtrl::class,'filtros'])->name('');
            Route::post('/', [FiltroProductoCtrl::class,'guardar']);
            Route::post('/eliminar', [FiltroProductoCtrl::class,'eliminar'])->name('-eliminar');
        });

        // Inventario
        Route::prefix($n='inventario')->name($n)->group(function (){
            Route::get('/', [ProductoCtrl::class,'inventario'])->name('');
            Route::post('/', [ProductoCtrl::class,'guardar']);
            Route::post('/eliminar', [ProductoCtrl::class,'eliminar'])->name('-eliminar');
        });

        // Combos

        // Cupones

        // Ordenes de compra

    });
});