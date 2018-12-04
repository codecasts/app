<?php

namespace Codecasts\Support\Routing\Console;

use Illuminate\Contracts\Console\Kernel;

/**
 * Class RouteFile.
 *
 * Base console route file implementation.
 */
abstract class RouteFile
{
    /**
     * @var Kernel Console Kernel
     */
    protected $artisan;

    /**
     * @var Kernel Console Kernel
     */
    protected $router;

    /**
     * RouteFile constructor.
     */
    public function __construct()
    {
        // alias artisan instance (console kernel).
        $this->artisan = app(Kernel::class);
        // alias artisan (console kernel) as 'router'.
        $this->router = $this->artisan;
    }

    /**
     * Register Console Routes
     *
     * @return array
     */
    public function register()
    {
        return $this->routes();
    }

    /**
     * Console routes array.
     *
     * @return array.
     */
    public function routes() : array
    {
        return [];
    }
}