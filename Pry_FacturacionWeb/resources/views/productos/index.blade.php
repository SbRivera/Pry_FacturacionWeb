@extends('layouts.app')
@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-semibold">Productos</h1>
    <a href="{{ route('productos.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Nuevo Producto</a>
</div>
<table class="min-w-full bg-white shadow rounded">
    <thead class="bg-gray-200">
        <tr>
            <th class="px-4 py-2">Nombre</th>
            <th class="px-4 py-2">Stock</th>
            <th class="px-4 py-2">Precio</th>
            <th class="px-4 py-2">Acciones</th>
        </tr>
    </thead>
    <tbody>
    @foreach($productos as $producto)
        <tr class="border-t">
            <td class="px-4 py-2">{{ $producto->nombre }}</td>
            <td class="px-4 py-2">{{ $producto->stock }}</td>
            <td class="px-4 py-2">{{ number_format($producto->precio,2) }}</td>
            <td class="px-4 py-2">
                <a href="{{ route('productos.edit', $producto) }}" class="text-blue-500 hover:underline">Editar</a>
                <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-500 hover:underline ml-2">Eliminar</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection