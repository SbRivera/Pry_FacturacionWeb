@extends('layouts.app')

@section('content')
<div class="bg-blue-950 bg-opacity-70 p-6 rounded-lg shadow-lg">
    <h2 class="text-3xl font-semibold text-cyan-300">Dashboard</h2>
    <p class="text-black mt-4">Aquí puedes empezar a gestionar tus productos, usuarios y más.</p>
    
    @if(isset($users) && $users->count() > 0)
        <div class="mt-6">
            <label for="usuario" class="text-black block mb-2">Selecciona un usuario:</label>
            <select id="usuario" class="mt-2 mb-4 p-3 rounded-lg bg-blue-200 text-blue-900 border border-blue-300 focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 min-w-64">
                <option value="">-- Seleccione un usuario --</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">
                        {{ $user->name }} 
                        @if($user->email)
                            ({{ $user->email }})
                        @endif
                    </option>
                @endforeach
            </select>
            
            <div class="mt-4">
                <button id="btnGenerarToken" class="bg-cyan-600 hover:bg-cyan-700 text-black font-bold py-2 px-4 rounded-lg transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                    <svg class="inline h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-3.586l4.293-4.293A6 6 0 0119 9z"></path>
                    </svg>
                    Generar Token para Usuario
                </button>
            </div>
        </div>
    @else
        <div class="mt-6 bg-yellow-600 bg-opacity-70 p-4 rounded-lg">
            <p class="text-yellow-100">
                <svg class="inline h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                No hay usuarios disponibles en el sistema.
            </p>
        </div>
    @endif
    
    @if(isset($stats))
        <div class="mt-6 bg-blue-800 bg-opacity-50 p-4 rounded-lg">
            <h3 class="text-cyan-200 font-semibold mb-2">Información del Usuario</h3>
            <p class="text-blue-100">
                <strong>Usuario:</strong> {{ $stats['user_name'] ?? 'N/A' }}<br>
                <strong>Rol:</strong> {{ $stats['user_role'] ?? 'Sin rol asignado' }}
            </p>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const usuarioSelect = document.getElementById('usuario');
    const btnGenerarToken = document.getElementById('btnGenerarToken');
    
    usuarioSelect.addEventListener('change', function() {
        if (this.value) {
            btnGenerarToken.disabled = false;
        } else {
            btnGenerarToken.disabled = true;
        }
    });
    
    btnGenerarToken.addEventListener('click', function() {
        const usuarioId = usuarioSelect.value;
        const usuarioNombre = usuarioSelect.options[usuarioSelect.selectedIndex].text;
        
        if (usuarioId) {
            alert(`Funcionalidad de generar token para: ${usuarioNombre}\nID: ${usuarioId}\n\nEsta función se puede implementar enviando una petición AJAX al servidor.`);
        }
    });
});
</script>
@endsection
