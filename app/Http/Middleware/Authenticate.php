<?php

namespace PowerMs\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */    

    public function handle($request, Closure $next)
    {
        if (!Auth::check())
        {
            \Session::put('attemptUrl', \URL::current());            
            return redirect('control-panel/login');
        }

        return $next($request);
    }
}