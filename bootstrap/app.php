<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    // ->withMiddleware(function (Middleware $middleware) {
    //     //
    //     // \App\Http\Middleware\LogUserActivity::class;
    //     // $middleware->append(\App\Http\Middleware\LogUserActivity::class);
    //     // $middleware->append(\Illuminate\Session\Middleware\StartSession::class); // WAJIB!
    //     // $middleware->append(\App\Http\Middleware\LogUserActivity::class);

    //     // $middleware->append(StartSession::class);
    //     // $middleware->append(VerifyCsrfToken::class);
    //     // $middleware->append(ShareErrorsFromSession::class);

    //     // // Middleware custom kamu (log, dll)
    //     // $middleware->append(\App\Http\Middleware\LogUserActivity::class);
    //     $middleware->append(StartSession::class); //  aktifkan session
    //     $middleware->append(VerifyCsrfToken::class); // agar csrf token divalidasi
    //     $middleware->append(ShareErrorsFromSession::class); // biar pesan error jalan
    //     $middleware->append(\App\Http\Middleware\LogUserActivity::class); // logging kamu

    // })

    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(StartSession::class);

        $middleware->append(\App\Http\Middleware\LogUserActivity::class);
    })
    
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
