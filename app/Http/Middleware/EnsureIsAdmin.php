<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar que el usuario esté autenticado
        if (!auth()->check()) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('login');
        }

        // Verificar que el usuario esté activo
        if (!auth()->user()->is_active) {
            auth()->logout();
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Your account is inactive.'], 403);
            }
            return redirect()->route('login')
                ->withErrors('Su cuenta ha sido desactivada. Contacte al administrador.');
        }

        // Verificar que tenga rol de administrador
        if (!auth()->user()->hasRole('Administrador')) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Insufficient permissions.'], 403);
            }
            abort(403, 'No tienes permisos de administrador para acceder a esta función.');
        }

        return $next($request);
    }
}
