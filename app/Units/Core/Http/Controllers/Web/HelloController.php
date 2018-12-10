<?php

namespace Codecasts\Units\Core\Http\Controllers\Web;

use Illuminate\Foundation\Inspiring;
use Codecasts\Support\Http\Controller;

/**
 * Class HelloController.
 *
 * Hello (world) controller
 */
class HelloController extends Controller
{
    /**
     * @var string Unit slug.
     */
    protected $unit = 'core';

    /**
     * Hello world controller method.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function hello()
    {
        return $this->view('hello');
    }
}