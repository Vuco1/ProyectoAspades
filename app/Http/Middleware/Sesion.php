<?php

namespace App\Http\Middleware;

use Closure;

class Sesion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(session()){
            return view('vistasusuario/iniciousuario');
        }else{
            return $next($request);
        }
        
    }
}
