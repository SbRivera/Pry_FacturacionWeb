@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Clientes</h2>
                        <p class="text-gray-600 dark:text-gray-400">Listado de todos los clientes registrados</p>
                    </div>
                    <a href="{{ route('clientes.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow transition">
                        + Nuevo Cliente
                    </a>
                </div>

                <div class="overflow-x-auto bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow border border-gray-200 dark:border-gray-600">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold">Nombre</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold">Email</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold">Teléfono</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($clientes as $cliente)
                                <tr>
                                    <td class="px-4 py-2">{{ $cliente->nombre }}</td>
                                    <td class="px-4 py-2">{{ $cliente->email }}</td>
                                    <td class="px-4 py-2">{{ $cliente->telefono }}</td>
                                    <td class="px-4 py-2 space-x-2">
                                        <a href="{{ route('clientes.edit', $cliente) }}" 
                                           class="text-blue-600 hover:underline dark:text-blue-400">Editar</a>
                                        <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline dark:text-red-400">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            @if($clientes->isEmpty())
                                <tr>
                                    <td colspan="4" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                                        No hay clientes registrados.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
