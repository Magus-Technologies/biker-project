<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckTiendaSession
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && !$request->session()->has('tienda_id')) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Sesión expirada. Por favor, inicia sesión nuevamente.');
        }

        return $next($request);
    }
}