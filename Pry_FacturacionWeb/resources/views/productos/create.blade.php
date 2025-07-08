@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-semibold mb-4">Crear Producto</h1>
<form action="{{ route('productos.store') }}" method="POST" class="bg-white p-6 shadow rounded">
    @csrf
    <div class="mb-4">
        <label class="block mb-1">Nombre</label>
        <input name="nombre" value="{{ old('nombre') }}" class="w-full border p-2 rounded">
        @error('nombre')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
    </div>
    <div class="mb-4">
        <label class="block mb-1">Descripción</label>
        <textarea name="descripcion" class="w-full border p-2 rounded">{{ old('descripcion') }}</textarea>
        @error('descripcion')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
    </div>
    <div class="mb-4">
        <label class="block mb-1">Stock</label>
        <input type="number" name="stock" value="{{ old('stock') }}" class="w-full border p-2 rounded">
        @error('stock')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
    </div>
    <div class="mb-4">
        <label class="block mb-1">Precio</label>
        <input name="precio" value="{{ old('precio') }}" class="w-full border p-2 rounded">
        @error('precio')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
    </div>
    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Guardar</button>
</form>
@endsection