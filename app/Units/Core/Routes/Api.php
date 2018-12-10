<?php

namespace Codecasts\Units\Core\Routes;

use Codecasts\Support\Routing\Http\RouteFile;

/**
 * Api Routes.
 */
class Api extends RouteFile
{
    /**
     * Declare Web Routes.
     */
    public function routes()
    {
        // ping route for testing.
        $this->router->get('ping/{ping?}', 'PingController@ping');
        $this->router->get('', 'PingController@teaPot');
    }
}
