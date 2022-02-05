<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LogHitsonEndpointsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $array = [
            "url" => \request()->fullUrl(),
            "sent_requests" => $request->all()
        ];
        file_put_contents();
        return $next($request);
    }
}
