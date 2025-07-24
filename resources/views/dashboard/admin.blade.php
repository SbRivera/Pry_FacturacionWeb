@extends('layouts.app')

@section('title', 'Dashboard Administrador')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Welcome Header -->
        <div class="bg-gradient-to-r from-blue-600 to-cyan-600 rounded-2xl p-8 text-white shadow-lg mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">¡Bienvenido, {{ auth()->user()->name }}!</h1>
                    <p class="text-blue-100 text-lg">Panel de administración del sistema FacturaPro</p>
                </div>
                <div class="hidden lg:block">
                    <svg class="h-20 w-20 text-blue-200 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
            <!-- Total Clientes -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Clientes</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['total_clientes'] }}</p>
                        <p class="text-sm text-green-600 mt-1">
                            <span class="font-semibold">{{ $stats['clientes_activos'] }}</span> activos
                        </p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Productos -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Productos</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['total_productos'] }}</p>
                        <p class="text-sm text-green-600 mt-1">
                            <span class="font-semibold">{{ $stats['productos_activos'] }}</span> activos
                        </p>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Facturas -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Facturas</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['total_facturas'] }}</p>
                        <p class="text-sm text-green-600 mt-1">
                            <span class="font-semibold">{{ $stats['facturas_activas'] }}</span> activas
                        </p>
                    </div>
                    <div class="bg-purple-100 rounded-full p-3">
                        <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Ventas del Mes -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Ventas del Mes</p>
                        <p class="text-3xl font-bold text-gray-900">${{ number_format($stats['ventas_mes'], 0, ',', '.') }}</p>
                        <p class="text-sm text-blue-600 mt-1">
                            Hoy: <span class="font-semibold">${{ number_format($stats['ventas_hoy'], 0, ',', '.') }}</span>
                        </p>
                    </div>
                    <div class="bg-yellow-100 rounded-full p-3">
                        <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alertas -->
        @if($stats['productos_bajo_stock'] > 0)
        <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-lg mb-8">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Productos con stock bajo</h3>
                    <p class="text-sm text-red-700 mt-1">
                        {{ $stats['productos_bajo_stock'] }} productos necesitan reposición.
                        <a href="{{ route('productos.index') }}" class="font-medium underline hover:text-red-600">Ver productos</a>
                    </p>
                </div>
            </div>
        </div>
        @endif

        <!-- Contenido Principal -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Top Productos (2/3 del ancho) -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="h-5 w-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        Productos Más Vendidos
                    </h3>
                    @if(isset($topProductos) && $topProductos->count() > 0)
                        <div class="space-y-3">
                            @foreach($topProductos as $index => $producto)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full 
                                                {{ $index === 0 ? 'bg-yellow-100 text-yellow-800' : 
                                                   ($index === 1 ? 'bg-gray-100 text-gray-800' : 'bg-orange-100 text-orange-800') }}">
                                                {{ $index + 1 }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $producto->nombre }}</p>
                                            <p class="text-xs text-gray-500">${{ number_format($producto->precio, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-bold text-green-600">{{ $producto->total_vendido ?? 0 }}</p>
                                        <p class="text-xs text-gray-500">vendidos</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">No hay datos de ventas aún</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Acciones Rápidas (1/3 del ancho) -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="h-5 w-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Acciones Rápidas
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('clientes.create') }}" class="w-full flex items-center justify-center px-4 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 transform hover:scale-105 shadow-md">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            Nuevo Cliente
                        </a>
                        
                        <a href="{{ route('productos.create') }}" class="w-full flex items-center justify-center px-4 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-medium rounded-lg hover:from-green-600 hover:to-green-700 transition-all duration-200 transform hover:scale-105 shadow-md">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Nuevo Producto
                        </a>
                        
                        <a href="{{ route('facturas.create') }}" class="w-full flex items-center justify-center px-4 py-3 bg-gradient-to-r from-purple-500 to-purple-600 text-white font-medium rounded-lg hover:from-purple-600 hover:to-purple-700 transition-all duration-200 transform hover:scale-105 shadow-md">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Nueva Factura
                        </a>
                        
                        <a href="{{ route('users.create') }}" class="w-full flex items-center justify-center px-4 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-medium rounded-lg hover:from-red-600 hover:to-red-700 transition-all duration-200 transform hover:scale-105 shadow-md">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            Nuevo Usuario
                        </a>
                        
                        <div class="border-t pt-3 mt-3">
                            <a href="{{ route('clientes.index') }}" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Ver Clientes
                            </a>
                        </div>
                        
                        <a href="{{ route('productos.index') }}" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors duration-200">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Ver Productos
                        </a>
                        
                        <a href="{{ route('facturas.index') }}" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors duration-200">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Ver Facturas
                        </a>
                        
                        <a href="{{ route('users.index') }}" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors duration-200">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            Gestionar Usuarios
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Segunda Fila - Gráficos e Información -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
            <!-- Gráfico de Ventas (Placeholder) -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="h-5 w-5 text-cyan-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Ventas de los últimos 30 días
                </h3>
                <div class="h-48 bg-gradient-to-br from-cyan-50 to-blue-50 rounded-lg flex items-center justify-center border border-cyan-100">
                    <div class="text-center">
                        <svg class="mx-auto h-12 w-12 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <p class="mt-2 text-sm text-cyan-600 font-medium">Gráfico de ventas</p>
                        <p class="text-xs text-cyan-500">Próximamente con Chart.js</p>
                    </div>
                </div>
            </div>

            <!-- Información del Sistema -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="h-5 w-5 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Información del Sistema
                </h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Total Usuarios</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $stats['total_usuarios'] }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Usuarios Activos</span>
                        <span class="text-sm font-semibold text-green-600">{{ $stats['usuarios_activos'] }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Laravel</span>
                        <span class="text-sm font-semibold text-blue-600">{{ app()->version() }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-sm text-gray-600">PHP</span>
                        <span class="text-sm font-semibold text-purple-600">{{ PHP_VERSION }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gestión de Tokens API -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Generar Token -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="h-5 w-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-3.586l4.293-4.293A6 6 0 0119 9z"></path>
                    </svg>
                    Generar Token API
                </h3>
                
                <form action="{{ route('dashboard.generate-token') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">Seleccionar Usuario</label>
                        <select name="user_id" id="user_id" required 
                                class="w-full px-3 py-2 border text-black border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Seleccione un usuario...</option>
                            @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->id }}">{{ $usuario->name }} ({{ $usuario->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="token_name" class="block text-sm font-medium text-gray-700 mb-2">Nombre del Token</label>
                        <input type="text" name="token_name" id="token_name" required 
                               placeholder="Ej: Token para aplicación móvil"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 placeholder-gray-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Permisos del Token</label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="abilities[]" value="read" checked 
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Lectura (read)</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="abilities[]" value="create" 
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Crear (create)</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="abilities[]" value="update" 
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Actualizar (update)</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="abilities[]" value="delete" 
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Eliminar (delete)</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit" 
                            class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200 font-medium">
                        <svg class="inline h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Generar Token
                    </button>
                </form>
            </div>

            <!-- Revocar Tokens -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="h-5 w-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    Revocar Tokens
                </h3>
                
                <form action="{{ route('dashboard.revoke-tokens') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label for="revoke_user_id" class="block text-sm font-medium text-gray-700 mb-2">Seleccionar Usuario</label>
                        <select name="user_id" id="revoke_user_id" required 
                                class="w-full px-3 py-2 border text-black border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            <option value="">Seleccione un usuario...</option>
                            @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->id }}">{{ $usuario->name }} ({{ $usuario->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex">
                            <svg class="h-5 w-5 text-red-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-red-800">¡Atención!</h4>
                                <p class="text-sm text-red-700 mt-1">Esta acción revocará TODOS los tokens del usuario seleccionado. Esta acción no se puede deshacer.</p>
                            </div>
                        </div>
                    </div>

                    <button type="submit" 
                            onclick="return confirm('¿Estás seguro de que quieres revocar todos los tokens de este usuario? Esta acción no se puede deshacer.')"
                            class="w-full bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors duration-200 font-medium">
                        <svg class="inline h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Revocar Todos los Tokens
                    </button>
                </form>
            </div>
        </div>

        <!-- Tabla de Tokens Existentes -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="h-5 w-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Tokens API Existentes
            </h3>
            
            @if(isset($tokens) && $tokens->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Usuario
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nombre del Token
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Permisos
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Creado
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Último Uso
                                </th>
                                {{-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estado
                                </th> --}}
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($tokens as $token)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                                <span class="text-sm font-medium text-blue-800">
                                                    {{ substr($token->user_name, 0, 1) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ $token->user_name }}</div>
                                            <div class="text-sm text-gray-500">{{ $token->user_email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $token->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        @php
                                            $abilities = json_decode($token->abilities, true) ?? [];
                                        @endphp
                                        @if(empty($abilities) || in_array('*', $abilities))
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Todos los permisos
                                            </span>
                                        @else
                                            @foreach($abilities as $ability)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-1 mb-1">
                                                    {{ $ability }}
                                                </span>
                                            @endforeach
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($token->created_at)->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($token->last_used_at)
                                        {{ \Carbon\Carbon::parse($token->last_used_at)->format('d/m/Y H:i') }}
                                    @else
                                        <span class="text-gray-400">Nunca usado</span>
                                    @endif
                                </td>
                                {{-- <td class="px-6 py-4 whitespace-nowrap">
                                    @if($token->last_used_at && \Carbon\Carbon::parse($token->last_used_at)->gt(\Carbon\Carbon::now()->subDays(7)))
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Activo
                                        </span>
                                    @elseif($token->last_used_at)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Inactivo
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Sin usar
                                        </span>
                                    @endif
                                </td> --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <!-- Botón Ver Token -->
                                        <button onclick="showTokenDetails('{{ $token->id }}', '{{ $token->name }}', '{{ $token->user_name }}', '{{ addslashes(json_encode($abilities)) }}', 'hidden_for_security')" 
                                                class="text-blue-600 hover:text-blue-900 transition-colors duration-200 p-1" 
                                                title="Ver detalles del token">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </button>
                                        
                                        <!-- Botón Regenerar Token -->
                                        <form action="{{ route('dashboard.regenerate-token') }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="token_id" value="{{ $token->id }}">
                                            <button type="submit" 
                                                    class="text-green-600 hover:text-green-900 transition-colors duration-200 p-1"
                                                    title="Regenerar token">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                </svg>
                                            </button>
                                        </form>
                                        
                                        <!-- Botón Revocar Token -->
                                        <form action="{{ route('dashboard.revoke-specific-token') }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="token_id" value="{{ $token->id }}">
                                            <button type="submit" 
                                                    onclick="return confirm('¿Estás seguro de que quieres revocar este token? Esta acción no se puede deshacer.')"
                                                    class="text-red-600 hover:text-red-900 transition-colors duration-200 p-1"
                                                    title="Revocar token">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-3.586l4.293-4.293A6 6 0 0119 9z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay tokens generados</h3>
                    <p class="mt-1 text-sm text-gray-500">Genera tu primer token API usando el formulario de arriba.</p>
                </div>
            @endif
        </div>

        <!-- Modal para mostrar el token generado -->
        @if(session('token'))
        <div id="tokenModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-md bg-white">
                <div class="mt-3 text-black">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="h-6 w-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Token Generado Exitosamente
                        </h3>
                        <button onclick="closeTokenModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-900 mb-2">
                            <strong>Usuario:</strong> {{ session('user_name') }}<br>
                            <strong>Nombre del Token:</strong> {{ session('token_name') }}
                        </p>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-900 mb-2">Token de Acceso:</label>
                        <div class="relative">
                            <input type="text" id="tokenValue" value="{{ session('token') }}" readonly 
                                   class="w-full px-3 py-2 pr-20 border border-gray-300 rounded-lg bg-gray-50 text-gray-900 text-sm font-mono">
                            <button onclick="copyToken()" 
                                    class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700">
                                Copiar
                            </button>
                        </div>
                    </div>
                    
                    
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                        <div class="flex">
                            <svg class="h-5 w-5 text-yellow-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-yellow-800">¡Importante!</h4>
                                <p class="text-sm text-yellow-700 mt-1">
                                    Asegúrate de copiarlo y guardarlo en un lugar seguro. 
                                    No podrás verlo nuevamente.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end">
                        <button onclick="closeTokenModal()" 
                                class="bg-gray-600 text-white py-2 px-4 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Modal para mostrar detalles del token -->
        <div id="tokenDetailsModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-md bg-white">
                <div class="mt-3 text-black">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="h-6 w-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Detalles del Token
                        </h3>
                        <button onclick="closeTokenDetailsModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div id="tokenDetailsContent">
                    </div>
                    
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                        <div class="flex">
                            <svg class="h-5 w-5 text-green-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-green-800">Información de Seguridad</h4>
                                <p class="text-sm text-green-700 mt-1">
                                    Como administrador, puedes ver la información del token y regenerarlo si es necesario.
                                    El token completo solo se muestra una vez durante la generación por razones de seguridad.
                                </p>
                                <p class="text-sm text-green-700 mt-1">
                                    <strong>Si necesitas el token completo:</strong> usa el botón "Regenerar" en la tabla de tokens.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end">
                        <button onclick="closeTokenDetailsModal()" 
                                class="bg-gray-600 text-white py-2 px-4 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
function copyToken() {
    const tokenInput = document.getElementById('tokenValue');
    tokenInput.select();
    tokenInput.setSelectionRange(0, 99999);
    document.execCommand('copy');
    
    // Mostrar feedback visual
    const button = event.target;
    const originalText = button.textContent;
    button.textContent = '¡Copiado!';
    button.classList.add('bg-green-600');
    button.classList.remove('bg-blue-600');
    
    setTimeout(() => {
        button.textContent = originalText;
        button.classList.remove('bg-green-600');
        button.classList.add('bg-blue-600');
    }, 2000);
}

function closeTokenModal() {
    document.getElementById('tokenModal').style.display = 'none';
}

function showTokenDetails(tokenId, tokenName, userName, abilities, tokenHash) {
    const modal = document.getElementById('tokenDetailsModal');
    const content = document.getElementById('tokenDetailsContent');
    
    // Parsear abilities si es un string JSON
    let parsedAbilities;
    try {
        parsedAbilities = typeof abilities === 'string' ? JSON.parse(abilities) : abilities;
    } catch (e) {
        parsedAbilities = [];
    }
    
    // Crear el contenido del modal
    let abilitiesHtml = '';
    if (parsedAbilities.length === 0 || parsedAbilities.includes('*')) {
        abilitiesHtml = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Todos los permisos</span>';
    } else {
        parsedAbilities.forEach(ability => {
            abilitiesHtml += `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-1 mb-1">${ability}</span>`;
        });
    }
    
    // Verificar si tenemos el token real o solo información
    const isTokenHidden = tokenHash === 'hidden_for_security';
    
    content.innerHTML = `
        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Usuario:</label>
                    <p class="text-sm text-gray-900 bg-gray-50 p-2 rounded">${userName}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del Token:</label>
                    <p class="text-sm text-gray-900 bg-gray-50 p-2 rounded">${tokenName}</p>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Token de Acceso:</label>
                ${isTokenHidden ? `
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex">
                        <svg class="h-5 w-5 text-yellow-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <div class="ml-3">
                            <h4 class="text-sm font-medium text-yellow-800">Token no disponible por seguridad</h4>
                            <p class="text-sm text-yellow-700 mt-1">
                                Por razones de seguridad, el token completo no se almacena y solo se muestra una vez durante la generación.
                            </p>
                            <p class="text-sm text-yellow-700 mt-1">
                                <strong>Opciones:</strong>
                            </p>
                            <ul class="text-sm text-yellow-700 mt-1 ml-4 list-disc">
                                <li>Usar el token que guardaste cuando se generó</li>
                                <li>Regenerar el token usando el botón correspondiente</li>
                            </ul>
                        </div>
                    </div>
                </div>
                ` : `
                <div class="space-y-2">
                    <input type="text" id="tokenDetailsValue" value="${tokenHash}" readonly 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-900 text-sm font-mono">
                    <button onclick="copyTokenDetails()" 
                            class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors duration-200 text-sm font-medium">
                        <svg class="inline h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        Copiar Token
                    </button>
                </div>
                `}
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Permisos Asignados:</label>
                <div class="bg-gray-50 p-3 rounded">
                    ${abilitiesHtml}
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">ID del Token:</label>
                <p class="text-sm text-gray-500 bg-gray-50 p-2 rounded font-mono">${tokenId}</p>
            </div>
        </div>
    `;
    
    modal.classList.remove('hidden');
}

function closeTokenDetailsModal() {
    document.getElementById('tokenDetailsModal').classList.add('hidden');
}

function copyTokenDetails() {
    const tokenInput = document.getElementById('tokenDetailsValue');
    tokenInput.select();
    tokenInput.setSelectionRange(0, 99999);
    document.execCommand('copy');
    
    // Mostrar feedback visual
    const button = event.target;
    const originalText = button.textContent;
    button.textContent = '¡Copiado!';
    button.classList.add('bg-green-600');
    button.classList.remove('bg-blue-600');
    
    setTimeout(() => {
        button.textContent = originalText;
        button.classList.remove('bg-green-600');
        button.classList.add('bg-blue-600');
    }, 2000);
}
</script>
@endsection
