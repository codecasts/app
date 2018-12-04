<?php

namespace Codecasts\Support\Routing\Http;

use Illuminate\Routing\Router;

/**
 * Class RouteFile.
 *
 * HTTP route file implementation.
 */
abstract class RouteFile
{
    /**
     * @var Router HTTP router instance.
     */
    protected $router;

    /**
     * @var array Router options.
     */
    protected $options;

    /**
     * RouteFile constructor.
     *
     * @param array $options List of group options.
     */
    public function __construct(array $options)
    {
        // assign router instance.
        $this->router = app('router');
        // pass custom options.
        $this->options = $options;
    }

    /**
     * Register Routes.
     */
    public function register()
    {
        $this->router->group($this->options, function () {
            $this->routes();
        });
    }

    /**
     * Define HTTP routes.
     */
    public function routes()
    {
        //
    }
}