@extends('layouts.app')
@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-semibold">Clientes</h1>
    <a href="{{ route('clientes.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Nuevo Cliente</a>
</div>
<table class="min-w-full bg-white shadow rounded">
    <thead class="bg-gray-200">
        <tr>
            <th class="px-4 py-2">Nombre</th>
            <th class="px-4 py-2">Email</th>
            <th class="px-4 py-2">Teléfono</th>
            <th class="px-4 py-2">Acciones</th>
        </tr>
    </thead>
    <tbody>
    @foreach($clientes as $cliente)
        <tr class="border-t">
            <td class="px-4 py-2">{{ $cliente->nombre }}</td>
            <td class="px-4 py-2">{{ $cliente->email }}</td>
            <td class="px-4 py-2">{{ $cliente->telefono }}</td>
            <td class="px-4 py-2">
                <a href="{{ route('clientes.edit', $cliente) }}" class="text-blue-500 hover:underline">Editar</a>
                <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-500 hover:underline ml-2">Eliminar</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection