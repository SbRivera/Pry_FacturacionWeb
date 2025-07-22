<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Middleware global para verificar estado del usuario
        $middleware->web(append: [
            \App\Http\Middleware\CheckUserStatus::class,
        ]);
        
        // Middleware con alias
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
            'user.status' => \App\Http\Middleware\CheckUserStatus::class,
            'verified.admin' => \App\Http\Middleware\EnsureEmailIsVerifiedOrAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
