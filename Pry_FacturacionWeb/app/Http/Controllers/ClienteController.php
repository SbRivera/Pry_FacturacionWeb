<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user.status');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Cliente::with('facturas');
        
        // Filtro de búsqueda
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telefono', 'like', "%{$search}%");
            });
        }
        
        // Filtro de estado
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status);
        }
        
        $clientes = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create_clientes');
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create_clientes');
        
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|min:2',
            'email' => 'required|email|unique:clientes,email|max:255',
            'telefono' => 'nullable|string|max:20|min:7',
        ]);

        $cliente = Cliente::create($validated);
        
        return redirect()->route('clientes.index')
            ->with('success', 'Cliente creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        $this->authorize('view_clientes');
        
        $facturas = $cliente->facturas()
            ->with('productos')
            ->orderBy('created_at', 'desc')
            ->paginate(5);
            
        return view('clientes.show', compact('cliente', 'facturas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        $this->authorize('edit_clientes');
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $this->authorize('edit_clientes');
        
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|min:2',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('clientes')->ignore($cliente->id)
            ],
            'telefono' => 'nullable|string|max:20|min:7',
            'is_active' => 'boolean',
        ]);

        $cliente->update($validated);
        
        return redirect()->route('clientes.index')
            ->with('success', 'Cliente actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        $this->authorize('delete_clientes');
        
        // Verificar si tiene facturas activas
        if ($cliente->facturas()->where('estado', 'activa')->count() > 0) {
            return redirect()->route('clientes.index')
                ->with('error', 'No se puede eliminar el cliente porque tiene facturas activas.');
        }
        
        $cliente->delete();
        
        return redirect()->route('clientes.index')
            ->with('success', 'Cliente eliminado exitosamente.');
    }

    /**
     * Mostrar formulario para asignar roles (solo administradores)
     */
    public function roles(Cliente $cliente)
    {
        $this->authorize('manage_roles');
        
        $roles = Role::all();
        $users = User::where('is_active', true)->get();
        
        return view('clientes.roles', compact('cliente', 'roles', 'users'));
    }

    /**
     * Asignar roles a un usuario cliente
     */
    public function assignRole(Request $request, Cliente $cliente)
    {
        $this->authorize('manage_roles');
        
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
        ]);
        
        $user = User::findOrFail($validated['user_id']);
        
        // Sincronizar roles
        $user->syncRoles($validated['roles']);
        
        return redirect()->route('clientes.index')
            ->with('success', 'Roles asignados exitosamente.');
    }

    /**
     * Cambiar estado del cliente
     */
    public function toggleStatus(Cliente $cliente)
    {
        $this->authorize('edit_clientes');
        
        $cliente->update([
            'is_active' => !$cliente->is_active
        ]);
        
        $status = $cliente->is_active ? 'activado' : 'desactivado';
        
        return redirect()->route('clientes.index')
            ->with('success', "Cliente {$status} exitosamente.");
    }
}
