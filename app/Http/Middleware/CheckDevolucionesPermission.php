<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckDevolucionesPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si el usuario tiene permisos para acceder a devoluciones
        if (!auth()->check()) {
            return redirect('login');
        }

        $user = auth()->user();
        
        // Permitir acceso a administradores y usuarios con rol de ventas
        if ($user->hasRole(['administrador', 'ventas'])) {
            return $next($request);
        }

        // Verificar permisos específicos
        if ($user->hasPermissionTo('ver-devoluciones') || 
            $user->hasPermissionTo('crear-devoluciones') || 
            $user->hasPermissionTo('editar-devoluciones') || 
            $user->hasPermissionTo('eliminar-devoluciones')) {
            return $next($request);
        }

        // Si no tiene permisos, redirigir o mostrar error
        if ($request->expectsJson()) {
            return response()->json(['error' => 'No tienes permisos para acceder a devoluciones'], 403);
        }

        return redirect()->back()->with('error', 'No tienes permisos para acceder a devoluciones');
    }
}
