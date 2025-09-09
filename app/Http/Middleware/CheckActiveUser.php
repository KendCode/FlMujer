<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ✅ Importar Auth

class CheckActiveUser
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) { // en vez de auth()->check()
            if (Auth::user()->estado !== 'activo') { // en vez de auth()->user()
                return redirect('/')->with('error', 'Tu cuenta no está activa.');
            }
        }

        return $next($request);
    }
}
