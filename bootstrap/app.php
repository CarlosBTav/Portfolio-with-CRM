<?php

use App\Services\Notifications\TelegramNotifier;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

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
        // Avisa de errores 500 al bot personal de Telegram. Ignora 4xx, errores
        // de validación y los de consola/cola (esos se quedan en el log).
        $exceptions->report(function (Throwable $e): void {
            if ($e instanceof HttpExceptionInterface || $e instanceof ValidationException) {
                return;
            }

            if (app()->runningInConsole()) {
                return;
            }

            try {
                $request = request();
                (new TelegramNotifier())->sendServerError($e, $request->method(), $request->fullUrl());
            } catch (Throwable) {
                // Que un fallo al avisar no rompa el manejo del error original.
            }
        });
    })->create();
