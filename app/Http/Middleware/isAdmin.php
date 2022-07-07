<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class isAdmin
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
        // if (Auth::user() && Auth::user()->roles == 'ADMIN') {
        //     return $next($request);
        // }
        if (!Auth::check() && Auth::user()->roles != 'ADMIN' || Auth::user()->roles != 'SUPERADMIN') {
            # code...
            abort(403);
        }
        return $next($request);

        // return back()->with('error','Opps, You\'re not Admin');
        // return redirect('/');
    }
}
