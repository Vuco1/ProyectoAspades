<?php

namespace App\Http\Middleware;

use Closure;

class Usuario {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $usuario_rol = \Session::get('rol');
        if ($usuario_rol == 0) {
            return $next($request);
        } else {
            return response()->view('errors/errorpermisos', [], 401);
        }
    }

}
