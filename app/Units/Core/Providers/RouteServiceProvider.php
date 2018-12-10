<?php

namespace Codecasts\Units\Core\Providers;

use Codecasts\Units\Core\Routes\Api;
use Codecasts\Units\Core\Routes\Web;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Codecasts\Units\Core\Routes\Console;

/**
 * Class RouteServiceProvider
 *
 * Core unit routes service provider.
 */
class RouteServiceProvider extends ServiceProvider
{
    /**
     * @var string Namespace is applied to your controller routes.
     */
    protected $namespace = 'Codecasts\Units\Core\Http\Controllers';

    /**
     * Define the routes for the application.
     */
    public function map()
    {
        // map API.
        $this->mapApiRoutes();

        // map WEB.
        $this->mapWebRoutes();

        // map Console.
        $this->mapConsoleRoutes();
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     */
    protected function mapApiRoutes()
    {
        (new Api([
            'middleware' => ['api'],
            'prefix' => 'api',
            'namespace'  => $this->namespace . '\Api',
            'as'         => 'core::',
        ]))->register();
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     */
    protected function mapWebRoutes()
    {
        (new Web([
            'middleware' => ['web'],
            'namespace'  => $this->namespace . '\Web',
            'as'         => 'core::',
        ]))->register();
    }

    /**
     * Console routes.
     */
    protected function mapConsoleRoutes()
    {
        $this->commands((new Console())->register());
    }
}
