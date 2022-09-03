<?php

namespace App\Http\Middleware;

use Closure;

class Cek_transaksi
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
        if (Auth::user() && Auth::user()->roles == 'Admin') {
            // dd($next);
            return $next($request);
        }
        return redirect('/');
    }
}
