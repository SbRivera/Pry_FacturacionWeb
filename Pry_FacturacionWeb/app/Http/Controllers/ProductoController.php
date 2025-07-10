<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user.status');
        $this->middleware('role:Bodega,Administrador');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Producto::query();
        
        // Filtro de búsqueda
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }
        
        // Filtro de estado
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status);
        }
        
        // Filtro de stock bajo
        if ($request->has('low_stock') && $request->low_stock) {
            $query->where('stock', '<', 10);
        }
        
        $productos = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('productos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|min:2',
            'descripcion' => 'nullable|string|max:1000',
            'stock' => 'required|integer|min:0',
            'precio' => 'required|numeric|min:0.01|max:999999.99',
        ]);

        $producto = Producto::create($validated);
        
        return redirect()->route('productos.index')
            ->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        $facturas = $producto->facturas()
            ->with('cliente')
            ->orderBy('created_at', 'desc')
            ->paginate(5);
            
        return view('productos.show', compact('producto', 'facturas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|min:2',
            'descripcion' => 'nullable|string|max:1000',
            'stock' => 'required|integer|min:0',
            'precio' => 'required|numeric|min:0.01|max:999999.99',
            'is_active' => 'boolean',
        ]);

        $producto->update($validated);
        
        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        // Verificar si el producto está en facturas activas
        $facturasActivas = $producto->facturas()
            ->where('estado', 'activa')
            ->count();
            
        if ($facturasActivas > 0) {
            return redirect()->route('productos.index')
                ->with('error', 'No se puede eliminar el producto porque está en facturas activas.');
        }
        
        $producto->delete();
        
        return redirect()->route('productos.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }

    /**
     * Cambiar estado del producto
     */
    public function toggleStatus(Producto $producto)
    {
        $producto->update([
            'is_active' => !$producto->is_active
        ]);
        
        $status = $producto->is_active ? 'activado' : 'desactivado';
        
        return redirect()->route('productos.index')
            ->with('success', "Producto {$status} exitosamente.");
    }

    /**
     * Obtener productos activos con stock para AJAX
     */
    public function getActiveProducts()
    {
        $productos = Producto::where('is_active', true)
            ->where('stock', '>', 0)
            ->select('id', 'nombre', 'precio', 'stock')
            ->get();
            
        return response()->json($productos);
    }

    /**
     * Verificar stock disponible
     */
    public function checkStock(Request $request, Producto $producto)
    {
        $cantidad = $request->input('cantidad', 1);
        
        $available = $producto->stock >= $cantidad;
        
        return response()->json([
            'available' => $available,
            'stock' => $producto->stock,
            'requested' => $cantidad
        ]);
    }
}
