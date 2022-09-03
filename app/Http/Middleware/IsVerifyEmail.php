<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsVerifyEmail
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
        if (!Auth::user()->is_email_verified) {
            auth()->logout();
            return redirect()->route('login')
                ->with('error', 'You need to confirm your account. We have sent you an activation code, please check your email.');
        }

        return $next($request);
    }
}
