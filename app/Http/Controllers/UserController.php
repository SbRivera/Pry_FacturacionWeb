<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        // Verificar que sea administrador
        if (!auth()->user()->hasRole('Administrador')) {
            abort(403, 'No tienes permisos para gestionar usuarios.');
        }
        
        $users = User::with('roles')->paginate(10);
        
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        // Verificar que sea administrador
        if (!auth()->user()->hasRole('Administrador')) {
            abort(403, 'No tienes permisos para crear usuarios.');
        }
        
        $roles = Role::all();
        
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        // Verificar que sea administrador
        if (!auth()->user()->hasRole('Administrador')) {
            abort(403, 'No tienes permisos para crear usuarios.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'exists:roles,id'],
            'is_active' => ['boolean'],
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'is_active' => $request->boolean('is_active', true),
            ]);

            // Asignar rol
            $role = Role::findById($request->role);
            $user->assignRole($role);

            DB::commit();

            return redirect()->route('users.index')
                ->with('success', 'Usuario creado exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear el usuario: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        // Verificar que sea administrador
        if (!auth()->user()->hasRole('Administrador')) {
            abort(403, 'No tienes permisos para ver usuarios.');
        }
        
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        // Verificar que sea administrador
        if (!auth()->user()->hasRole('Administrador')) {
            abort(403, 'No tienes permisos para editar usuarios.');
        }
        
        $roles = Role::all();
        
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        // Verificar que sea administrador
        if (!auth()->user()->hasRole('Administrador')) {
            abort(403, 'No tienes permisos para actualizar usuarios.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'exists:roles,id'],
            'is_active' => ['boolean'],
        ]);

        try {
            DB::beginTransaction();

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'is_active' => $request->boolean('is_active', true),
            ]);

            // Actualizar contraseña si se proporciona
            if ($request->filled('password')) {
                $user->update([
                    'password' => Hash::make($request->password),
                ]);
            }

            // Actualizar rol
            $role = Role::findById($request->role);
            $user->syncRoles([$role]);

            DB::commit();

            return redirect()->route('users.index')
                ->with('success', 'Usuario actualizado exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar el usuario: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Verificar que sea administrador
        if (!auth()->user()->hasRole('Administrador')) {
            abort(403, 'No tienes permisos para eliminar usuarios.');
        }

        // No permitir eliminar al propio usuario
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        // No permitir eliminar al último administrador
        $adminRole = Role::where('name', 'Administrador')->first();
        $adminCount = User::role('Administrador')->count();
        
        if ($user->hasRole('Administrador') && $adminCount <= 1) {
            return redirect()->route('users.index')
                ->with('error', 'No puedes eliminar al último administrador del sistema.');
        }

        try {
            DB::beginTransaction();
            
            $user->delete();
            
            DB::commit();

            return redirect()->route('users.index')
                ->with('success', 'Usuario eliminado exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('users.index')
                ->with('error', 'Error al eliminar el usuario: ' . $e->getMessage());
        }
    }

    /**
     * Toggle user status (active/inactive).
     */
    public function toggleStatus(User $user)
    {
        // Verificar que sea administrador
        if (!auth()->user()->hasRole('Administrador')) {
            abort(403, 'No tienes permisos para cambiar el estado de usuarios.');
        }

        // No permitir desactivar al propio usuario
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'No puedes desactivar tu propia cuenta.');
        }

        try {
            DB::beginTransaction();
            
            $user->update([
                'is_active' => !$user->is_active,
            ]);
            
            DB::commit();

            $status = $user->is_active ? 'activado' : 'desactivado';

            return redirect()->route('users.index')
                ->with('success', "Usuario {$status} exitosamente.");
                
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('users.index')
                ->with('error', 'Error al cambiar el estado del usuario: ' . $e->getMessage());
        }
    }
    
    /**
     * Generar token de acceso para un usuario
     */
    public function generateToken(Request $request)
    {
        // Verificar que sea administrador
        if (!auth()->user()->hasRole('Administrador')) {
            return response()->json(['error' => 'No tienes permisos para generar tokens.'], 403);
        }
        
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'token_name' => 'required|string|max:255',
            'abilities' => 'array',
            'abilities.*' => 'string'
        ]);
        
        try {
            $user = User::findOrFail($validated['user_id']);
            
            // Verificar que el usuario esté activo
            if (!$user->is_active) {
                return redirect()->back()
                    ->with('error', 'No se puede generar un token para un usuario inactivo.');
            }
            
            // Definir habilidades disponibles
            $defaultAbilities = ['read', 'create', 'update'];
            $abilities = $validated['abilities'] ?? $defaultAbilities;
            
            // Generar el token
            $token = $user->createToken($validated['token_name'], $abilities);
            
            return redirect()->back()
                ->with('success', 'Token generado exitosamente.')
                ->with('token', $token->plainTextToken)
                ->with('token_name', $validated['token_name'])
                ->with('user_name', $user->name);
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al generar el token: ' . $e->getMessage());
        }
    }
    
    /**
     * Revocar todos los tokens de un usuario
     */
    public function revokeTokens(Request $request)
    {
        // Verificar que sea administrador
        if (!auth()->user()->hasRole('Administrador')) {
            return response()->json(['error' => 'No tienes permisos para revocar tokens.'], 403);
        }
        
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);
        
        try {
            $user = User::findOrFail($validated['user_id']);
            
            // Contar tokens antes de revocar
            $tokenCount = $user->tokens()->count();
            
            // Revocar todos los tokens del usuario
            $user->tokens()->delete();
            
            return redirect()->back()
                ->with('success', "Se revocaron {$tokenCount} tokens de {$user->name}.");
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al revocar los tokens: ' . $e->getMessage());
        }
    }
    
    /**
     * Mostrar tokens de un usuario
     */
    public function showTokens(User $user)
    {
        // Verificar que sea administrador
        if (!auth()->user()->hasRole('Administrador')) {
            abort(403, 'No tienes permisos para ver tokens de usuarios.');
        }
        
        // Obtener información de tokens (sin el token actual por seguridad)
        $tokens = $user->tokens()->select('id', 'name', 'abilities', 'created_at', 'last_used_at')->get();
        
        return view('users.tokens', compact('user', 'tokens'));
    }
    
    /**
     * Revocar un token específico
     */
    public function revokeSpecificToken(Request $request, User $user)
    {
        // Verificar que sea administrador
        if (!auth()->user()->hasRole('Administrador')) {
            return response()->json(['error' => 'No tienes permisos para revocar tokens.'], 403);
        }
        
        $validated = $request->validate([
            'token_id' => 'required|exists:personal_access_tokens,id'
        ]);
        
        try {
            $token = $user->tokens()->where('id', $validated['token_id'])->first();
            
            if (!$token) {
                return redirect()->back()
                    ->with('error', 'Token no encontrado o no pertenece a este usuario.');
            }
            
            $tokenName = $token->name;
            $token->delete();
            
            return redirect()->back()
                ->with('success', "Token '{$tokenName}' revocado exitosamente.");
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al revocar el token: ' . $e->getMessage());
        }
    }
}
