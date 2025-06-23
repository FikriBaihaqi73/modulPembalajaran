<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\MentorMiddleware;


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
        $middleware->trustProxies(at: '*');

        // Daftarkan middleware kustom
        $middleware->alias([
            'admin' => 'App\Http\Middleware\AdminMiddleware',
            'mentor' => 'App\Http\Middleware\MentorMiddleware',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (ValidationException $e, Request $request) {
            return back()->withInput($request->input())->withErrors($e->errors());
        });

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

        $exceptions->render(function (HttpException $e, Request $request) {
            $statusCode = $e->getStatusCode();
            $errorMessage = 'Terjadi kesalahan.';
            $suggestion = 'Silakan coba lagi atau kembali ke beranda.';

            switch ($statusCode) {
                case 401:
                    $errorMessage = 'Maaf, Anda tidak memiliki otentikasi untuk mengakses halaman ini.';
                    $suggestion = 'Silakan login kembali atau hubungi administrator.';
                    break;
                case 403:
                    $errorMessage = 'Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.';
                    $suggestion = 'Jika Anda merasa ini adalah kesalahan, harap hubungi administrator.';
                    break;
                case 419:
                    $errorMessage = 'Halaman telah kedaluwarsa karena tidak aktif.';
                    $suggestion = 'Harap segarkan halaman dan coba lagi.';
                    break;
                case 429:
                    $errorMessage = 'Terlalu banyak permintaan.';
                    $suggestion = 'Harap tunggu sebentar sebelum mencoba lagi.';
                    break;
                case 500:
                    $errorMessage = 'Terjadi kesalahan internal server.';
                    $suggestion = 'Silakan coba lagi nanti.';
                    break;
                default:
                    $errorMessage = $e->getMessage() ?: 'Terjadi kesalahan.';
                    $suggestion = 'Silakan coba lagi atau kembali ke beranda.';
                    break;
            }

            $data = [
                'errorMessage' => $errorMessage,
                'suggestion' => $suggestion,
                'status_code' => $statusCode,
                'dynamic_info' => ['timestamp' => now()->toDateTimeString(), 'request_path' => $request->path()],
            ];

            $viewName = "errors.{$statusCode}";
            if (!view()->exists($viewName)) {
                $viewName = 'errors.500';
            }

            return response()->view($viewName, $data, $statusCode);
        });

        $exceptions->render(function (Throwable $e, Request $request) {
            if ($e instanceof HttpException) {
                return false;
            }

            $data = [
                'errorMessage' => 'Terjadi kesalahan tak terduga.',
                'suggestion' => 'Kami sedang berupaya memperbaikinya. Silakan coba lagi nanti.',
                'status_code' => 500,
                'dynamic_info' => ['timestamp' => now()->toDateTimeString(), 'request_path' => $request->path()],
            ];

            return response()->view('errors.500', $data, 500);
        });

    })->create();
