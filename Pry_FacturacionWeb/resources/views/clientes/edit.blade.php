@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-semibold mb-4">Editar Cliente</h1>
<form action="{{ route('clientes.update', $cliente) }}" method="POST" class="bg-white p-6 shadow rounded">
    @csrf @method('PUT')
    <div class="mb-4">
        <label class="block mb-1">Nombre</label>
        <input type="text" name="nombre" value="{{ old('nombre', $cliente->nombre) }}" class="w-full border p-2 rounded">
        @error('nombre')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
    </div>
    <div class="mb-4">
        <label class="block mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email', $cliente->email) }}" class="w-full border p-2 rounded">
        @error('email')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
    </div>
    <div class="mb-4">
        <label class="block mb-1">Teléfono</label>
        <input type="text" name="telefono" value="{{ old('telefono', $cliente->telefono) }}" class="w-full border p-2 rounded">
        @error('telefono')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
    </div>
    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">Actualizar</button>
</form>
@endsection