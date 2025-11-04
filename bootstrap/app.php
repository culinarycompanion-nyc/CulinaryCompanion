<?php

use App\Http\Middleware\AcceptTerms;
use App\Http\Middleware\SitePassword;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\Middleware\StartSession;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->web(append: [
            SitePassword::class,
            AcceptTerms::class,
            // You can add other web middleware here, such as AcceptTerms::class
        ]);



        // $middleware->append(StartSession::class);
        // $middleware->append(SitePassword::class);
        // $middleware->append(AcceptTerms::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
