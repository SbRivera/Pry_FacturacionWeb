<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

// IMPORTANTE: Todas las rutas API deben devolver JSON, no redireccionar a login
Route::group(['middleware' => ['api']], function () {

    // Ruta de prueba sin autenticación
    Route::get('/test', function () {
        return response()->json([
            'success' => true,
            'message' => 'API funcionando correctamente',
            'timestamp' => now(),
            'version' => '1.0.0'
        ]);
    });

    // Ruta para debuggear autenticación SIN middleware auth
    Route::get('/debug-auth', function (Request $request) {
        $headers = $request->headers->all();
        $token = $request->bearerToken();
        
        // Intentar autenticar manualmente
        $user = null;
        if ($token) {
            try {
                $user = \Laravel\Sanctum\PersonalAccessToken::findToken($token)?->tokenable;
            } catch (\Exception $e) {
                // Token inválido
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Debug de autenticación',
            'token_present' => !empty($token),
            'token_preview' => $token ? substr($token, 0, 10) . '...' : null,
            'authorization_header' => $request->header('Authorization'),
            'accept_header' => $request->header('Accept'),
            'content_type' => $request->header('Content-Type'),
            'user_agent' => $request->header('User-Agent'),
            'user_found_with_token' => $user ? true : false,
            'user_name' => $user ? $user->name : null,
            'token_abilities' => $token ? (\Laravel\Sanctum\PersonalAccessToken::findToken($token)?->abilities ?? []) : null
        ]);
    });

    
    // Rutas que requieren autenticación - con manejo personalizado de errores
    Route::middleware(['api'])->group(function () {
        
        Route::get('/user', function (Request $request) {
            // Verificar token manualmente para mejor control de errores
            $token = $request->bearerToken();
            
            if (!$token) {
                return response()->json([
                    'error' => 'Token de autorización requerido',
                    'message' => 'Incluye el header: Authorization: Bearer {tu-token}',
                    'debug' => [
                        'headers_received' => [
                            'Authorization' => $request->header('Authorization'),
                            'Accept' => $request->header('Accept'),
                            'Content-Type' => $request->header('Content-Type')
                        ]
                    ]
                ], 401);
            }
            
            // Buscar el token
            $accessToken = \Laravel\Sanctum\PersonalAccessToken::findToken($token);
            
            if (!$accessToken) {
                return response()->json([
                    'error' => 'Token inválido o expirado',
                    'message' => 'El token proporcionado no es válido',
                    'debug' => [
                        'token_preview' => substr($token, 0, 10) . '...'
                    ]
                ], 401);
            }
            
            $user = $accessToken->tokenable;
            
            if (!$user) {
                return response()->json([
                    'error' => 'Usuario no encontrado',
                    'message' => 'El token es válido pero el usuario asociado no existe'
                ], 401);
            }
            
            return response()->json([
                'success' => true,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'is_active' => $user->is_active,
                    'roles' => $user->roles->pluck('name'),
                    'created_at' => $user->created_at
                ],
                'token_info' => [
                    'name' => $accessToken->name,
                    'abilities' => $accessToken->abilities,
                    'last_used_at' => $accessToken->last_used_at
                ]
            ]);
        });

        Route::get('/users', function (Request $request) {
            try {
                // Verificar token manualmente
                $token = $request->bearerToken();
                
                if (!$token) {
                    return response()->json([
                        'error' => 'Token de autorización requerido',
                        'message' => 'Incluye el header: Authorization: Bearer {tu-token}'
                    ], 401);
                }
                
                $accessToken = \Laravel\Sanctum\PersonalAccessToken::findToken($token);
                
                if (!$accessToken) {
                    return response()->json([
                        'error' => 'Token inválido o expirado'
                    ], 401);
                }
                
                $currentUser = $accessToken->tokenable;
                
                if (!$currentUser) {
                    return response()->json([
                        'error' => 'Usuario no encontrado'
                    ], 401);
                }
                
                // Verificar permisos
                if (!$currentUser->hasRole('Administrador') && !$currentUser->hasPermissionTo('gestionar-usuarios')) {
                    return response()->json([
                        'error' => 'No tienes permisos para ver la lista de usuarios',
                        'your_role' => $currentUser->roles->pluck('name'),
                        'required_permission' => 'Administrador o gestionar-usuarios'
                    ], 403);
                }
                
                // Obtener todos los usuarios con sus roles
                $users = User::with('roles')->get()->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'is_active' => $user->is_active,
                        'roles' => $user->roles->pluck('name'),
                        'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                        'updated_at' => $user->updated_at->format('Y-m-d H:i:s')
                    ];
                });
                
                return response()->json([
                    'success' => true,
                    'message' => 'Lista de usuarios obtenida correctamente',
                    'requested_by' => [
                        'name' => $currentUser->name,
                        'email' => $currentUser->email,
                        'roles' => $currentUser->roles->pluck('name')
                    ],
                    'total_users' => $users->count(),
                    'users' => $users
                ]);
                
            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'Error interno del servidor',
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ], 500);
            }
        });

        // Ruta simple para listar solo nombres y emails
        Route::get('/users/simple', function (Request $request) {
            $token = $request->bearerToken();
            
            if (!$token) {
                return response()->json(['error' => 'Token requerido'], 401);
            }
            
            $accessToken = \Laravel\Sanctum\PersonalAccessToken::findToken($token);
            
            if (!$accessToken) {
                return response()->json(['error' => 'Token inválido'], 401);
            }
            
            $currentUser = $accessToken->tokenable;
            
            if (!$currentUser) {
                return response()->json(['error' => 'Usuario no encontrado'], 401);
            }
            
            $users = User::select('id', 'name', 'email', 'is_active')->get();
            
            return response()->json([
                'success' => true,
                'requested_by' => $currentUser->name,
                'users' => $users
            ]);
        });
    });

});
