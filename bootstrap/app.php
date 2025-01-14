<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
    $middleware->validateCsrfTokens(except: [
        '/login-form', // Exclude all routes starting with 'stripe/'
        '/registration-form', // Exclude all routes starting with 'webhook/'
        '/verify-otp',
        '/reset-password',
    ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
