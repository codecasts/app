<?php

namespace Codecasts\Units\Core\Http\Controllers\Api;

use Illuminate\Foundation\Inspiring;
use Codecasts\Support\Http\Controller;

/**
 * Class PingController.
 *
 * Simple and dummy ping-pong response to allow testing the API is working without an actual call.
 */
class PingController extends Controller
{
    /**
     * Ping-Pong handler method.
     *
     * @param string|null  $ping
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ping($ping = null)
    {
        // return response.
        return $this->respond->ok([ 'ping' => $ping ], 'pong');
    }

    /**
     * Tea Pot funny.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function teaPot()
    {
        return $this->respond->generic([], Inspiring::quote());
    }
}