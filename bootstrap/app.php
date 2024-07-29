<?php

use App\Exceptions\ErrorException;
use App\Http\Middleware\ForceJsonResponse;
use App\Traits\UseResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        apiPrefix: 'api/v1',
        then: function () {
            /**
             * Route สำหรับการทำ Versioning API
             */
            // Route::middleware('api')
            //     ->prefix('api/v2')
            //     ->group(base_path('routes/api_v2.php'));
        }
    )
    ->withBroadcasting(
        __DIR__ . '/../routes/channels.php',
        [
            'prefix' => 'api',
            'middleware' => ['auth:sanctum'],
        ]
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            'sanctum/csrf-cookie',
            'api/*',
        ]);
        $middleware->append(ForceJsonResponse::class);
        $middleware->statefulApi();
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'static_token_auth' => \App\Http\Middleware\StaticTokenAuth::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (ErrorException $e, Request $request) {
            return UseResponse::error(
                error: null,
                message: $e->getMessage(),
                code: 500
            );
        });

        $exceptions->render(function (ValidationException $e, Request $request) {
            return UseResponse::error(
                error: $e->errors(),
                message: 'Validation error.',
                code: 422
            );
        });

        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($e->getPrevious() instanceof ModelNotFoundException) {
                // $modelName = ltrim(preg_replace('/[A-Z]/', ' $0', class_basename($e->getPrevious()->getModel()))) ?? null;

                return UseResponse::error(
                    message: 'No query results.',
                    code: 404
                );
            }

            return UseResponse::error(
                error: null,
                message: 'Resource not found.',
                code: 404
            );
        });

        $exceptions->render(function (UnauthorizedException|AuthenticationException $e, Request $request) {
            return UseResponse::error(
                error: null,
                message: 'Unauthorized.',
                code: 403
            );
        });

        $exceptions->render(function (QueryException $e, Request $request) {
            return UseResponse::error(
                error: $e->errorInfo[2] ?? null,
                message: 'Query error.',
                code: 500
            );
        });

        $exceptions->render(function (Exception $e, Request $request) {
            $error = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'exception' => get_class($e),
            ];

            $error = App::environment('local') ? $error : null;

            return UseResponse::error(
                error: $error,
                message: 'Internal server error.',
                code: 500
            );
        });
    })->create();
