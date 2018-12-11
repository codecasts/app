<?php

namespace Codecasts\Support\Http;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use League\Flysystem\Filesystem;
use Codecasts\Domains\Users\User;

/**
 * Class Controller
 *
 * Base controller implementation.
 */
abstract class Controller extends BaseController
{
    // enabled traits.
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var string|null Current unit where the controller belongs.
     */
    protected $unit = null;

    /**
     * @var int Default page size.
     */
    protected $pageSize = 30;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var Respond
     */
    protected $respond;

    /**
     * Controller constructor.
     *
     * Uses a middleware to always detect the running user on all requests.
     */
    public function __construct()
    {
        // assign a respond instance.
        $this->respond = new Respond();

        // user detection inline middleware.
        $this->middleware(function ($request, $next) {
            // assign user.
            $this->user = auth()->user();
            // complete request.
            return $next($request);
        });
    }

    /**
     * Parse fractal includes.
     *
     * @param Request $request
     *
     * @return array
     */
    public function parseIncludes(Request $request)
    {
        if ($request->filled('include')) {
            return (array)explode(',', $request->get('include'));
        }

        return [];
    }

    /**
     * Guard / Auth instance.
     *
     * @return Guard
     */
    protected function getAuth()
    {
        return auth()->guard();
    }

    /**
     * Storage instance.
     *
     * @return Filesystem
     */
    protected function getStorage()
    {
        return app()->make('filesystem.cloud')->getDriver();
    }

    /**
     * Request instance.
     *
     * @return \Illuminate\Http\Request
     */
    protected function getRequest()
    {
        return app()->make('request');
    }

    /**
     * Render a given view.
     *
     * @param string $name
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Http\Response
     */
    protected function view(string $name)
    {
        if ($this->unit != null) {
            return view("{$this->unit}::{$name}");
        }

        return view($name);
    }
}
