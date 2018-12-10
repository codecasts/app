<?php

namespace Codecasts\Units\Core\Routes;

use Codecasts\Support\Routing\Http\RouteFile;

/**
 * Api Routes.
 */
class Web extends RouteFile
{
    /**
     * Declare Web Routes.
     */
    public function routes()
    {
        $this->router->get('/home', 'HomeController@index')->name('home');

        // ping route for testing.
        $this->router->get('hello', 'HelloController@hello');
    }
}
