<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // dd($request);
        // dd($guard);
        if (Auth::guard($guard)->check()) {
            // dd(Auth::guard($guard)->user());
            if($guard == 'admin') {
                // dd('admin', $guard);
                return redirect('/admin');
            } else if($guard == "provider") {
                // dd('provider', $guard);
                return redirect('/provider');
            } else {
                // dd('sid', $guard);
                return redirect('/');
            }
        }
        // dd('Check Failed');

        return $next($request);
    }
}
