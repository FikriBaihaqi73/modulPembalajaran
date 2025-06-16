<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            'login',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) { // Contoh: Jika ini adalah permintaan API
                return response()->json([
                    'message' => 'Resource not found',
                    'code' => 404
                ], 404);
            }

            // Data yang ingin Anda teruskan ke halaman 404
            $data = [
                'errorMessage' => 'Halaman yang Anda cari tidak ditemukan.',
                'suggestion' => 'Silakan periksa kembali URL atau kembali ke beranda.',
                'status_code' => 404,
                'dynamic_info' => ['timestamp' => now()->toDateTimeString(), 'request_path' => $request->path()],
            ];

            return response()->view('errors.404', $data, 404);
        });
    })->create();
