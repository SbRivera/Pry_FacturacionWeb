<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Handle unauthenticated users.
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        // Si es una petición a la API, devolver JSON
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'error' => 'No autenticado',
                'message' => 'Token de acceso requerido o inválido',
                'debug' => [
                    'route' => $request->getPathInfo(),
                    'method' => $request->getMethod(),
                    'headers' => [
                        'Authorization' => $request->header('Authorization'),
                        'Accept' => $request->header('Accept'),
                        'Content-Type' => $request->header('Content-Type')
                    ]
                ]
            ], 401);
        }

        // Para rutas web, redirigir al login
        return redirect()->guest(route('login'));
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
    {
        // Para rutas API, siempre devolver JSON
        if ($request->is('api/*') || $request->expectsJson()) {
            
            // Errores de autenticación
            if ($exception instanceof AuthenticationException) {
                return response()->json([
                    'error' => 'No autenticado',
                    'message' => 'Token de acceso requerido o inválido'
                ], 401);
            }

            // Errores de validación
            if ($exception instanceof ValidationException) {
                return response()->json([
                    'error' => 'Datos de validación incorrectos',
                    'message' => 'Los datos enviados no son válidos',
                    'errors' => $exception->errors()
                ], 422);
            }

            // Error 404
            if ($exception instanceof NotFoundHttpException) {
                return response()->json([
                    'error' => 'Endpoint no encontrado',
                    'message' => 'La ruta solicitada no existe',
                    'requested_url' => $request->getPathInfo()
                ], 404);
            }

            // Otros errores
            return response()->json([
                'error' => 'Error interno del servidor',
                'message' => app()->environment('local') ? $exception->getMessage() : 'Ha ocurrido un error inesperado',
                'debug' => app()->environment('local') ? [
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'trace' => $exception->getTraceAsString()
                ] : null
            ], 500);
        }

        return parent::render($request, $exception);
    }
}
