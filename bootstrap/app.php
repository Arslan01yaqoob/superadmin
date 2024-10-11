<?php

use App\Http\Middleware\logCheck;
use App\Http\Middleware\SuperadminMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'isAdminlogin' => SuperadminMiddleware::class,
            'logcheck' => logCheck::class,

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
