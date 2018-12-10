<?php

namespace Codecasts\Units\Core\Routes;


use Codecasts\Support\Routing\Console\RouteFile;
use Codecasts\Units\Core\Console\HorizonLazyStart;

/**
 * Core Unit Console Routes.
 */
class Console extends RouteFile
{
    /**
     * Declare Console Routes.
     */
    public function routes() : array
    {
        return [
            HorizonLazyStart::class,
        ];
    }
}
