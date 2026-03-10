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
    ->withMiddleware(function (Middleware $middleware) {
        // Excepción de CSRF para los Webhooks de Stripe
        $middleware->validateCsrfTokens(except: [
            'stripe/*', 
            'webhook/stripe', // Por si acaso usas la ruta por defecto de Cashier
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();