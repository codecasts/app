<?php

namespace Codecasts\Units\Core\Providers;

use Illuminate\Broadcasting\Broadcasters\Broadcaster;
use Illuminate\Broadcasting\BroadcastManager;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Broadcasting\Factory as BroadcastFactory;

/**
 * Class BroadcastServiceProvider.
 */
class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        /** @var BroadcastManager|Broadcaster $broadcaster */
        $broadcaster = app()->make(BroadcastFactory::class);
        // set broadcasting route settings.
        $broadcaster->routes([
            // set middleware list.
            'middleware' => [ 'api' ]
        ]);

//        Broadcast::channel('Codecasts.User.{id}', function ($user, $id) {
//            return (int) $user->id === (int) $id;
//        });
    }
}
