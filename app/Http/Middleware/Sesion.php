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
        if (session() != null) {
            if (\Session::get('rol') == 1) {
                return response()->view('vistasadmin/inicioadmin', [], 401);
            } else {
                return response()->view('vistasusuario/iniciousuario', [], 401);
            }
        } else {
            return $next($request);
        }
    }

}
