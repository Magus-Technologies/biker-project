<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Tienda;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        $tiendas = Tienda::where('status', 1)->get();
        return view('auth.login', compact('tiendas'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->validate([
            'tienda_id' => ['required', 'exists:tiendas,id'],
        ]);

        $user = $request->user();
        $requestedTiendaId = $request->tienda_id;

        // VERIFICACIÓN DE ACCESO POR ROL Y TIENDA
        // Si el usuario no es Admin, se valida que la tienda seleccionada sea la suya.
        if (!$user->hasRole('administrador')) {
            if ($user->tienda_id != $requestedTiendaId) {
                // Si el vendedor intenta acceder a una tienda que no es la suya,
                // cerramos la sesión y lo devolvemos con un error.
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect('/login')->withErrors([
                    'tienda_id' => 'No tiene permiso para acceder a esta tienda.',
                ]);
            }
        }

        // Si la validación pasa (es Admin o es su tienda correcta), procedemos.
        $request->session()->regenerate();
        $request->session()->put('tienda_id', $requestedTiendaId);
        $request->session()->save();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Verificar token CSRF antes del logout
        if (!$request->hasValidSignature() && !$request->session()->token() === $request->input('_token')) {
            // Si hay problema con CSRF, regenerar token y redirigir
            $request->session()->regenerateToken();
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login'); // Cambiar a /login en lugar de /
    }
}