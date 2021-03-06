<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Rol;

class Permisos
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $permisos = ($rol = Rol::find( Auth::user()->rol ) ) ? $rol->permisos : "";
        $permisos = explode("," , $permisos);
        if(Auth::user()->administrador || in_array(prefijo(), $permisos) ){
            return $next($request);
        }
        else {
            return back();
        }
    }
}
