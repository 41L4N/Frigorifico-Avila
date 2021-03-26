<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

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
        // Accesos
        $prefijo = explode("/",$request->route()->getPrefix())[0];
        $accesos = [
            // Director
            "Director"   =>  ["perfil","administrador","perfiles","descargas"]
        ];
        if(in_array($prefijo,$accesos[Auth::user()->rol])){
            return $next($request);
        }
        else {
            return redirect()->route("perfil");
        }
    }
}
