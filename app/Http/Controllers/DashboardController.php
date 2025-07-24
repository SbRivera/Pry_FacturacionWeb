<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Factura;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Estadísticas básicas según el rol
        $stats = [];
        
        // Check if user is admin by email (fallback for role issues)
        $isAdmin = $user->hasRole('Administrador') || 
                   in_array($user->email, ['admin@empresa.com', 'admin@facturacion.com']);
        
        if ($isAdmin) {
            // Give admin role if they don't have it
            if (!$user->hasRole('Administrador')) {
                try {
                    DB::beginTransaction();
                    
                    $adminRole = \Spatie\Permission\Models\Role::where('name', 'Administrador')->first();
                    if ($adminRole) {
                        $user->assignRole($adminRole);
                    }
                    
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    // Log error but continue with dashboard
                    \Log::error('Error assigning admin role: ' . $e->getMessage());
                }
            }
            
            $stats = [
                'total_clientes' => Cliente::count(),
                'clientes_activos' => Cliente::where('is_active', true)->count(),
                'total_productos' => Producto::count(),
                'productos_activos' => Producto::where('is_active', true)->count(),
                'total_facturas' => Factura::count(),
                'facturas_activas' => Factura::where('estado', 'activa')->count(),
                'total_usuarios' => User::count(),
                'usuarios_activos' => User::where('is_active', true)->count(),
                'ventas_hoy' => Factura::whereDate('created_at', today())
                    ->where('estado', 'activa')
                    ->sum('total'),
                'ventas_mes' => Factura::whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->where('estado', 'activa')
                    ->sum('total'),
                'productos_bajo_stock' => Producto::where('stock', '<', 10)
                    ->where('is_active', true)
                    ->count(),
            ];
            
            // Gráficos adicionales para admin
            $ventasDiarias = $this->getVentasDiarias();
            $topProductos = $this->getTopProductos();
            
            // Lista de usuarios para el formulario de tokens
            $usuarios = User::where('is_active', true)->orderBy('name')->get();
            
            // Lista de tokens existentes con información del usuario
            $tokens = DB::table('personal_access_tokens')
                ->join('users', 'personal_access_tokens.tokenable_id', '=', 'users.id')
                ->select(
                    'personal_access_tokens.id',
                    'personal_access_tokens.name',
                    'personal_access_tokens.abilities',
                    'personal_access_tokens.token',
                    'personal_access_tokens.created_at',
                    'personal_access_tokens.last_used_at',
                    'users.name as user_name',
                    'users.email as user_email'
                )
                ->where('personal_access_tokens.tokenable_type', 'App\\Models\\User')
                ->orderBy('personal_access_tokens.created_at', 'desc')
                ->get();
            
            return view('dashboard.admin', compact('stats', 'ventasDiarias', 'topProductos', 'usuarios', 'tokens'));
            
        } elseif ($user->hasRole(['Secretario'])) {
            $stats = [
                'total_clientes' => Cliente::count(),
                'total_facturas' => Factura::count(),
                'ventas_hoy' => Factura::whereDate('created_at', today())
                    ->where('estado', 'activa')
                    ->sum('total'),
            ];
            
            return view('dashboard.secretario', compact('stats'));
            
        } elseif ($user->hasRole('Bodega')) {
            $stats = [
                'total_productos' => Producto::count(),
                'productos_activos' => Producto::where('is_active', true)->count(),
                'productos_bajo_stock' => Producto::where('stock', '<', 10)
                    ->where('is_active', true)
                    ->count(),
            ];
            
            $productosBajoStock = Producto::where('stock', '<', 10)
                ->where('is_active', true)
                ->get();
                
            return view('dashboard.bodega', compact('stats', 'productosBajoStock'));
            
        } elseif ($user->hasRole('Ventas')) {
            $stats = [
                'mis_facturas_hoy' => Factura::where('user_id', $user->id)
                    ->whereDate('created_at', today())
                    ->count(),
                'mis_ventas_hoy' => Factura::where('user_id', $user->id)
                    ->whereDate('created_at', today())
                    ->where('estado', 'activa')
                    ->sum('total'),
                'total_clientes' => Cliente::where('is_active', true)->count(),
                'productos_disponibles' => Producto::where('stock', '>', 0)
                    ->where('is_active', true)
                    ->count(),
            ];
            
            return view('dashboard.ventas', compact('stats'));
        }
        
        // Dashboard por defecto - agregar datos básicos
        $users = User::where('is_active', true)->orderBy('name')->get();
        $stats = [
            'mensaje' => 'Dashboard básico',
            'user_name' => $user->name,
            'user_role' => $user->roles->pluck('name')->first() ?? 'Sin rol asignado'
        ];
        
        return view('dashboard.default', compact('users', 'stats'));
    }
    
    private function getVentasDiarias()
    {
        return Factura::selectRaw('DATE(created_at) as fecha, SUM(total) as total')
            ->where('estado', 'activa')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();
    }
    
    private function getTopProductos()
    {
        return Producto::select('productos.*')
            ->join('factura_producto', 'productos.id', '=', 'factura_producto.producto_id')
            ->join('facturas', 'factura_producto.factura_id', '=', 'facturas.id')
            ->where('facturas.estado', 'activa')
            ->where('facturas.created_at', '>=', now()->subDays(30))
            ->selectRaw('productos.*, SUM(factura_producto.cantidad) as total_vendido')
            ->groupBy('productos.id')
            ->orderBy('total_vendido', 'desc')
            ->limit(5)
            ->get();
    }
    
    /**
     * Generar token para un usuario específico
     */
    public function generateToken(Request $request)
    {
        // Verificar que solo administradores puedan generar tokens
        if (!auth()->user()->hasRole('Administrador')) {
            return redirect()->route('dashboard')
                ->with('error', 'No tienes permisos para generar tokens.');
        }
        
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'token_name' => 'required|string|max:255',
            'abilities' => 'array',
            'abilities.*' => 'string'
        ]);
        
        try {
            $user = User::findOrFail($validated['user_id']);
            
            // Definir habilidades disponibles
            $defaultAbilities = ['read', 'create', 'update'];
            $abilities = $validated['abilities'] ?? $defaultAbilities;
            
            // Generar el token
            $token = $user->createToken($validated['token_name'], $abilities);
            
            return redirect()->route('dashboard')
                ->with('success', 'Token generado exitosamente.')
                ->with('token', $token->plainTextToken)
                ->with('token_name', $validated['token_name'])
                ->with('user_name', $user->name);
                
        } catch (\Exception $e) {
            return redirect()->route('dashboard')
                ->with('error', 'Error al generar el token: ' . $e->getMessage());
        }
    }
    
    /**
     * Revocar tokens de un usuario
     */
    public function revokeTokens(Request $request)
    {
        // Verificar que solo administradores puedan revocar tokens
        if (!auth()->user()->hasRole('Administrador')) {
            return redirect()->route('dashboard')
                ->with('error', 'No tienes permisos para revocar tokens.');
        }
        
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);
        
        try {
            $user = User::findOrFail($validated['user_id']);
            
            // Revocar todos los tokens del usuario
            $user->tokens()->delete();
            
            return redirect()->route('dashboard')
                ->with('success', "Todos los tokens de {$user->name} han sido revocados.");
                
        } catch (\Exception $e) {
            return redirect()->route('dashboard')
                ->with('error', 'Error al revocar los tokens: ' . $e->getMessage());
        }
    }
    
    /**
     * Revocar un token específico
     */
    public function revokeSpecificToken(Request $request)
    {
        // Verificar que solo administradores puedan revocar tokens
        if (!auth()->user()->hasRole('Administrador')) {
            return redirect()->route('dashboard')
                ->with('error', 'No tienes permisos para revocar tokens.');
        }
        
        $validated = $request->validate([
            'token_id' => 'required|exists:personal_access_tokens,id'
        ]);
        
        try {
            // Obtener información del token antes de eliminarlo
            $tokenInfo = DB::table('personal_access_tokens')
                ->join('users', 'personal_access_tokens.tokenable_id', '=', 'users.id')
                ->select('personal_access_tokens.name', 'users.name as user_name')
                ->where('personal_access_tokens.id', $validated['token_id'])
                ->first();
            
            // Eliminar el token específico
            DB::table('personal_access_tokens')
                ->where('id', $validated['token_id'])
                ->delete();
            
            return redirect()->route('dashboard')
                ->with('success', "Token '{$tokenInfo->name}' de {$tokenInfo->user_name} ha sido revocado exitosamente.");
                
        } catch (\Exception $e) {
            return redirect()->route('dashboard')
                ->with('error', 'Error al revocar el token: ' . $e->getMessage());
        }
    }
    
    /**
     * Regenerar un token específico
     */
    public function regenerateToken(Request $request)
    {
        // Verificar que solo administradores puedan regenerar tokens
        if (!auth()->user()->hasRole('Administrador')) {
            return redirect()->route('dashboard')
                ->with('error', 'No tienes permisos para regenerar tokens.');
        }
        
        $validated = $request->validate([
            'token_id' => 'required|exists:personal_access_tokens,id'
        ]);
        
        try {
            // Obtener información del token antes de eliminarlo
            $oldTokenInfo = DB::table('personal_access_tokens')
                ->join('users', 'personal_access_tokens.tokenable_id', '=', 'users.id')
                ->select(
                    'personal_access_tokens.name',
                    'personal_access_tokens.abilities',
                    'personal_access_tokens.tokenable_id',
                    'users.name as user_name'
                )
                ->where('personal_access_tokens.id', $validated['token_id'])
                ->first();
                
            if (!$oldTokenInfo) {
                return redirect()->route('dashboard')
                    ->with('error', 'Token no encontrado.');
            }
            
            // Eliminar el token anterior
            DB::table('personal_access_tokens')
                ->where('id', $validated['token_id'])
                ->delete();
                
            // Obtener el usuario
            $user = User::findOrFail($oldTokenInfo->tokenable_id);
            
            // Decodificar las habilidades
            $abilities = json_decode($oldTokenInfo->abilities, true) ?? ['read'];
            
            // Crear el nuevo token con las mismas características
            $newToken = $user->createToken($oldTokenInfo->name, $abilities);
            
            return redirect()->route('dashboard')
                ->with('success', "Token '{$oldTokenInfo->name}' regenerado exitosamente.")
                ->with('token', $newToken->plainTextToken)
                ->with('token_name', $oldTokenInfo->name)
                ->with('user_name', $oldTokenInfo->user_name);
                
        } catch (\Exception $e) {
            return redirect()->route('dashboard')
                ->with('error', 'Error al regenerar el token: ' . $e->getMessage());
        }
    }
    
    /**
     * Mostrar información detallada de un token específico
     */
    public function showToken(Request $request)
    {
        // Verificar que solo administradores puedan ver tokens
        if (!auth()->user()->hasRole('Administrador')) {
            return response()->json(['error' => 'No tienes permisos para ver tokens.'], 403);
        }
        
        $validated = $request->validate([
            'token_id' => 'required|exists:personal_access_tokens,id'
        ]);
        
        try {
            // Obtener información completa del token
            $tokenInfo = DB::table('personal_access_tokens')
                ->join('users', 'personal_access_tokens.tokenable_id', '=', 'users.id')
                ->select(
                    'personal_access_tokens.id',
                    'personal_access_tokens.name',
                    'personal_access_tokens.abilities',
                    'personal_access_tokens.token',
                    'personal_access_tokens.created_at',
                    'personal_access_tokens.last_used_at',
                    'users.name as user_name',
                    'users.email as user_email'
                )
                ->where('personal_access_tokens.id', $validated['token_id'])
                ->first();
                
            if (!$tokenInfo) {
                return response()->json(['error' => 'Token no encontrado.'], 404);
            }
            
            return response()->json([
                'success' => true,
                'token' => $tokenInfo
            ]);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener el token: ' . $e->getMessage()], 500);
        }
    }
}
