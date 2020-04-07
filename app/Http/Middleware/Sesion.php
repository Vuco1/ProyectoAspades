<?php

namespace App\Http\Middleware;

use Closure;

class Sesion {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (session()->exists('usuario')) {
            if (\Session::get('rol') == 1) {
                if (session()->has('idioma')) {
                    return response()->view('en/vistasadmin/inicioadmin', [], 401);
                } else {
                    return response()->view('es/vistasadmin/inicioadmin', [], 401);
                }
            } else {
                if (session()->has('idioma')) {
                    return response()->view('en/vistasusuario/iniciousuario', [], 401);
                } else {
                    return response()->view('es/vistasusuario/iniciousuario', [], 401);
                }
            }
        } else {
            return $next($request);
        }
    }

}
