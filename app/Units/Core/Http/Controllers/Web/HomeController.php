<?php

namespace Codecasts\Units\Core\Http\Controllers\Web;

use Codecasts\Support\Http\Controller;

/**
 * Class HomeController.
 *
 * Dummy home controller.
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        parent::__construct();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return $this->view('home');
    }
}