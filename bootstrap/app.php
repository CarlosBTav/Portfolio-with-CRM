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
        // Public documentation note forms are anonymous (no auth session) and rate-limited,
        // so CSRF verification would break mobile browsers that don't persist session cookies.
        $middleware->validateCsrfTokens(except: [
            'documentacion/*/apuntes',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
