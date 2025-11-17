<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use App\Http\Middleware\LargeFileUploadHandler;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'verified.customer' => EnsureEmailIsVerified::class . ':customer',
        ]);

        // Add global large file upload handler for admin routes
        $middleware->use([LargeFileUploadHandler::class]);

        // Exclude payment routes from CSRF protection
        $middleware->validateCsrfTokens(except: [
            'checkout/initiate-payment/*',
            'checkout/razorpay/callback',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
