<?php

namespace App\Http\Middleware;

use Closure;

class Idioma
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
        if (session()->has('lang')) {
            $lang = session()->get('lang');
            \App::setLocale($lang);
            app()->setLocale(session('lang'));
        }
        return $next($request);
    }
}
