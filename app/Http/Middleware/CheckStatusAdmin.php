<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckStatusAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ellenőrzi, hogy a bejelentkezett felhasználó státusza nagyobb-e mint 1
        if (auth()->check() && auth()->user()->status === 100) {
            return $next($request);
        }

        // Ha a felhasználó státusza nem felel meg, átirányíthatja őket egy másik oldalra
        return redirect('posts');
    }
}
