@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-semibold mb-4">Crear Cliente</h1>
<form action="{{ route('clientes.store') }}" method="POST" class="bg-white p-6 shadow rounded">
    @csrf
    <div class="mb-4">
        <label class="block mb-1">Nombre</label>
        <input type="text" name="nombre" value="{{ old('nombre') }}" class="w-full border p-2 rounded">
        @error('nombre')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
    </div>
    <div class="mb-4">
        <label class="block mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" class="w-full border p-2 rounded">
        @error('email')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
    </div>
    <div class="mb-4">
        <label class="block mb-1">Teléfono</label>
        <input type="text" name="telefono" value="{{ old('telefono') }}" class="w-full border p-2 rounded">
        @error('telefono')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
    </div>
    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Guardar</button>
</form>
@endsection