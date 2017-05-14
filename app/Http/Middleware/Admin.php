<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $auth = Auth::guard($guard);

        if ( $auth->check() !== true ) {
            return abort(404);
        }

        if ( $auth->user()->isAdmin !== true ) {
            return abort(404);
        }

        return $next($request);
    }
}
