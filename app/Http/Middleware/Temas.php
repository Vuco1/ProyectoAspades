<?php

namespace App\Http\Middleware;

use Closure;

class Temas
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
        $temas = \DB::table('temas')
                ->select('*')
                ->first();
        session()->put('temas', $temas);
        return $next($request);
    }
}
