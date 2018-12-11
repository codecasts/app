<?php

namespace Codecasts\Units;

use Illuminate\Foundation\Http\Kernel;
use Spatie\Cors\Cors;
use Illuminate\Foundation\Http\Middleware;
use Illuminate\Auth\Middleware as AuthMiddleware;
use Illuminate\Routing\Middleware as RoutingMiddleware;

/**
 * Class HttpKernel.
 *
 * Application HTTP Kernel.
 */
class HttpKernel extends Kernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        Core\Http\Middleware\CheckForMaintenanceMode::class,
        Middleware\ValidatePostSize::class,
        Core\Http\Middleware\TrimStrings::class,
        Middleware\ConvertEmptyStringsToNull::class,
        Core\Http\Middleware\TrustProxies::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            Core\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            Core\Http\Middleware\VerifyCsrfToken::class,
            RoutingMiddleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
            Cors::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth'              => Core\Http\Middleware\Authenticate::class,
        'auth.basic'        => AuthMiddleware\AuthenticateWithBasicAuth::class,
        'bindings'          => RoutingMiddleware\SubstituteBindings::class,
        'can'               => AuthMiddleware\Authorize::class,
        'guest'             => Core\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle'          => RoutingMiddleware\ThrottleRequests::class,
    ];
}
