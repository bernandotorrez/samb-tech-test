<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AllowedMethods
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $requestMethod = $request->method();

        $allowedMethods = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'];

        if (!in_array($requestMethod, $allowedMethods)) {
            return response('Method Not Allowed', 405);
        }

        return $next($request);
    }
}
