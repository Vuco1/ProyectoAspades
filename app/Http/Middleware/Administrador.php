<?php

namespace App\Http\Middleware;

use Closure;

class Administrador {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $usuario_rol = \Session::get('rol');
        if ($usuario_rol == 1) {
            return $next($request);
        } else {
            if (session()->has('idioma')) {
                return response()->view('errors/errorpermisosEn', [], 401);
            } else {
                return response()->view('errors/errorpermisos', [], 401);
            }
        }
    }

}
