<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && (auth()->user()->status === 'Inactive')) {
            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect()->route('user.banned')->with('error', 'Your Account is suspended, please contact Admin.');
        }

        return $next($request);
    }
}
