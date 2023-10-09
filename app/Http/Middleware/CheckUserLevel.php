<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// use Closure;
use Auth;

class CheckUserLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $level): Response
    {
        if ($level === 'Admin' && Auth::check() && Auth::user()->user_level == "Admin") {
            return $next($request);
        } elseif ($level === 'Standard' && Auth::check() && Auth::user()->user_level == "Standard") {
            return $next($request);
        } elseif ($level === 'Premium' && Auth::check() && Auth::user()->user_level == "Premium") {
            return $next($request);
        } elseif ($level === 'Basic') {
            return $next($request);
        }

        return redirect('/'); // Redirect jika level pengguna tidak diizinkan.

        // return $next($request);
    }
}