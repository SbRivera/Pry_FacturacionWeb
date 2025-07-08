@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-semibold mb-4">Crear Factura</h1>
<form action="{{ route('facturas.store') }}" method="POST" class="bg-white p-6 shadow rounded">
    @csrf
    <div class="mb-4">
        <label class="block mb-1">Cliente</label>
        <select name="cliente_id" class="w-full border p-2 rounded">
            <option value="">-- Seleccione --</option>
            @foreach($clientes as $cliente)
                <option value="{{ $cliente->id }}" {{ old('cliente_id')==$cliente->id?'selected':'' }}>{{ $cliente->nombre }}</option>
            @endforeach
        </select>
        @error('cliente_id')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
    </div>
    <div class="mb-4">
        <label class="block mb-1">Productos</label>
        <table class="w-full mb-4">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-2 py-1">Producto</th>
                    <th class="px-2 py-1">Cantidad</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productos as $prod)
                    <tr>
                        <td class="px-2 py-1">{{ $prod->nombre }} (Stock: {{ $prod->stock }})</td>
                        <td class="px-2 py-1">
                            <input type="number" name="productos[{{ $prod->id }}]" min="0" max="{{ $prod->stock }}" value="{{ old('productos.'.$prod->id,0) }}" class="w-20 border p-1 rounded">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @error('productos')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
    </div>
    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Generar Factura</button>
</form>
@endsection
