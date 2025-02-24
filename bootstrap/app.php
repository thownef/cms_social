<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        apiPrefix: 'api/',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->report(function (App\Exceptions\NoContentException $e) {
        })->stop();

        $exceptions->render(function (Throwable $th, Request $request) {
            if ($request->is('api') || $request->is('api/*')) {
                $apiException = resolve(App\Exceptions\ApiExceptionHandler::class);
                return $apiException->render($request, $th);
            }
        });
    })->create();
