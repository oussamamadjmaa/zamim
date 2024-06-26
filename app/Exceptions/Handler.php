<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Session\TokenMismatchException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    protected $auth;

    public function __construct(Container $container, AuthFactory $auth)
    {
        parent::__construct($container);
        $this->auth = $auth;
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        $routePrefix = getRoutePrefix();

        if (!$request->expectsJson() && ($exception instanceof NotFoundHttpException || $exception instanceof ModelNotFoundException)) {
            // Customize error page based on the panel
            if ($routePrefix === 'web' || !$this->auth->check()) {
                return response()->view('errors.frontend.404', [], 404);
            } elseif (in_array($routePrefix, ['school', 'portal', 'admin'])) {
                return response()->view('errors.backend.404', [], 404);
            }
        }

        if (!$request->expectsJson() && $exception instanceof TokenMismatchException) {
            return response()->view('errors.frontend.419', [], 404);
        }

        return parent::render($request, $exception);
    }
}
