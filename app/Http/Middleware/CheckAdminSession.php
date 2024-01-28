<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdminSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek kalau sudah login dan level nya bukan admin
        // maka lempar ke home nya backend
        // kalau belum login maka lempar ke home frontend

        if(Auth::check()) {
            $level = Auth::user()['level'];

            if($level != 'Admin') {
                return redirect(route('home'));
            }
        }

        return $next($request);
    }
}
