<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class CheckEmail
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
        $response = $next($request);

        if ( Auth::guest() === true ) {
            return $response;
        }

        if ( empty(Auth::user()->email) !== true ) {
            return $response;
        }

        if ( $request->getRequestUri() !== '/login/email' ) {
            return redirect()->route('auth.login.email')->with('flash.error', __('Lütfen devam edebilmek için yeni bir e-posta adresi belirleyin.'));
        }

        return $response;
    }
}
