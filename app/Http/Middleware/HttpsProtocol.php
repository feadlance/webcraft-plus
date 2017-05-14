<?php

namespace App\Http\Middleware;

use Closure;

class HttpsProtocol
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
        if ( config('app.env') === 'production' && config('lebby.https_protocol') === true ) {
            $request->setTrustedProxies([$request->getClientIp()]);

            if ( !$request->secure() ) {
                return redirect()->secure($request->getRequestUri());
            }
        }

        return $next($request);
    }
}
