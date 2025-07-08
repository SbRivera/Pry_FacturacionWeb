<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\FacturaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile',   [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    // Clientes (Administradores, Secretarios, Bodega o Ventas)
    Route::middleware('role:Administrador,Secretario,Bodega,Ventas')
         ->resource('clientes', ClienteController::class);

    // Productos (solo Bodega)
    Route::middleware('role:Bodega')
         ->resource('productos', ProductoController::class);

    // Facturas (solo Ventas)
    Route::middleware('role:Ventas')->group(function () {
        Route::resource('facturas', FacturaController::class);
        Route::post('facturas/{factura}/anular', [FacturaController::class, 'anular'])
             ->name('facturas.anular');
    });
});

require __DIR__.'/auth.php';
