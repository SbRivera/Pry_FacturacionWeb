@extends('layouts.app')
@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-semibold">Facturas</h1>
    <a href="{{ route('facturas.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Nueva Factura</a>
</div>
<table class="min-w-full bg-white shadow rounded">
    <thead class="bg-gray-200">
        <tr>
            <th class="px-4 py-2">#</th>
            <th class="px-4 py-2">Cliente</th>
            <th class="px-4 py-2">Total</th>
            <th class="px-4 py-2">Estado</th>
            <th class="px-4 py-2">Acciones</th>
        </tr>
    </thead>
    <tbody>
    @foreach($facturas as $factura)
        <tr class="border-t">
            <td class="px-4 py-2">{{ $factura->id }}</td>
            <td class="px-4 py-2">{{ $factura->cliente->nombre }}</td>
            <td class="px-4 py-2">{{ number_format($factura->total,2) }}</td>
            <td class="px-4 py-2">{{ ucfirst($factura->estado) }}</td>
            <td class="px-4 py-2">
                @if($factura->estado==='activa')
                    <form action="{{ route('facturas.anular', $factura) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-red-500 hover:underline">Anular</button>
                    </form>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
