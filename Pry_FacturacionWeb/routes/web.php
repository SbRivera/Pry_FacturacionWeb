<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard principal con control de roles
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'user.status'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile',   [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'user.status'])->group(function () {
    
    // === RUTAS DE GESTIÓN DE USUARIOS (Solo Administradores) ===
    Route::middleware('role:Administrador')->group(function () {
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('users', [UserController::class, 'store'])->name('users.store');
        Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    });
    
    // === RUTAS DE CLIENTES ===
    // IMPORTANTE: Las rutas específicas van primero (create antes que {cliente})
    Route::get('clientes', [ClienteController::class, 'index'])
        ->middleware('role:Administrador|Secretario|Ventas')
        ->name('clientes.index');
    
    Route::get('clientes/create', [ClienteController::class, 'create'])
        ->middleware('role:Administrador|Secretario')
        ->name('clientes.create');
        
    Route::post('clientes', [ClienteController::class, 'store'])
        ->middleware('role:Administrador|Secretario')
        ->name('clientes.store');
    
    Route::get('clientes/{cliente}', [ClienteController::class, 'show'])
        ->middleware('role:Administrador|Secretario|Ventas')
        ->name('clientes.show');
    
    Route::get('clientes/{cliente}/edit', [ClienteController::class, 'edit'])
        ->middleware('role:Administrador|Secretario')
        ->name('clientes.edit');
        
    Route::put('clientes/{cliente}', [ClienteController::class, 'update'])
        ->middleware('role:Administrador|Secretario')
        ->name('clientes.update');
        
    Route::patch('clientes/{cliente}/toggle-status', [ClienteController::class, 'toggleStatus'])
        ->middleware('role:Administrador|Secretario')
        ->name('clientes.toggle-status');
        
    Route::delete('clientes/{cliente}', [ClienteController::class, 'destroy'])
        ->middleware('role:Administrador')
        ->name('clientes.destroy');
        
    Route::get('clientes/{cliente}/roles', [ClienteController::class, 'roles'])
        ->middleware('role:Administrador')
        ->name('clientes.roles');
        
    Route::post('clientes/{cliente}/assign-role', [ClienteController::class, 'assignRole'])
        ->middleware('role:Administrador')
        ->name('clientes.assign-role');

    // === RUTAS DE PRODUCTOS ===
    // IMPORTANTE: Las rutas específicas van primero (create antes que {producto})
    Route::get('productos', [ProductoController::class, 'index'])
        ->middleware('role:Administrador|Bodega|Secretario|Ventas')
        ->name('productos.index');
        
    Route::get('productos/create', [ProductoController::class, 'create'])
        ->middleware('role:Administrador|Bodega')
        ->name('productos.create');
        
    Route::post('productos', [ProductoController::class, 'store'])
        ->middleware('role:Administrador|Bodega')
        ->name('productos.store');
        
    Route::get('api/productos/active', [ProductoController::class, 'getActiveProducts'])
        ->middleware('role:Administrador|Bodega|Secretario|Ventas')
        ->name('productos.api.active');
    
    Route::get('productos/{producto}', [ProductoController::class, 'show'])
        ->middleware('role:Administrador|Bodega|Secretario|Ventas')
        ->name('productos.show');
        
    Route::get('productos/{producto}/edit', [ProductoController::class, 'edit'])
        ->middleware('role:Administrador|Bodega')
        ->name('productos.edit');
        
    Route::put('productos/{producto}', [ProductoController::class, 'update'])
        ->middleware('role:Administrador|Bodega')
        ->name('productos.update');
        
    Route::patch('productos/{producto}/toggle-status', [ProductoController::class, 'toggleStatus'])
        ->middleware('role:Administrador|Bodega')
        ->name('productos.toggle-status');
        
    Route::delete('productos/{producto}', [ProductoController::class, 'destroy'])
        ->middleware('role:Administrador')
        ->name('productos.destroy');
        
    Route::post('api/productos/{producto}/check-stock', [ProductoController::class, 'checkStock'])
        ->middleware('role:Administrador|Bodega|Secretario|Ventas')
        ->name('productos.api.check-stock');

    // === RUTAS DE FACTURAS ===
    // IMPORTANTE: Las rutas específicas van primero (create antes que {factura})
    Route::get('facturas', [FacturaController::class, 'index'])
        ->middleware('role:Administrador|Secretario|Ventas|Bodega')
        ->name('facturas.index');
        
    Route::get('facturas/create', [FacturaController::class, 'create'])
        ->middleware('role:Administrador|Secretario|Ventas')
        ->name('facturas.create');
        
    Route::post('facturas', [FacturaController::class, 'store'])
        ->middleware('role:Administrador|Secretario|Ventas')
        ->name('facturas.store');
    
    Route::get('facturas/{factura}', [FacturaController::class, 'show'])
        ->middleware('role:Administrador|Secretario|Ventas|Bodega')
        ->name('facturas.show');
        
    Route::get('facturas/{factura}/edit', [FacturaController::class, 'edit'])
        ->middleware('role:Administrador|Secretario|Ventas')
        ->name('facturas.edit');
        
    Route::put('facturas/{factura}', [FacturaController::class, 'update'])
        ->middleware('role:Administrador|Secretario|Ventas')
        ->name('facturas.update');
        
    Route::get('facturas/{factura}/pdf', [FacturaController::class, 'generatePDF'])
        ->middleware('role:Administrador|Secretario|Ventas|Bodega')
        ->name('facturas.pdf');
        
    Route::patch('facturas/{factura}/anular', [FacturaController::class, 'anular'])
        ->middleware('role:Administrador|Secretario|Ventas')
        ->name('facturas.anular');
        
    Route::delete('facturas/{factura}', [FacturaController::class, 'destroy'])
        ->middleware('role:Administrador')
        ->name('facturas.destroy');
});

require __DIR__.'/auth.php';
