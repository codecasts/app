<?php

namespace Codecasts\Units\Core\Providers;

use Codecasts\Support\Units\ServiceProvider;

/**
 * Class UnitServiceProvider.
 *
 * Core unit service provider file.
 */
class UnitServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $slug = 'core';

    /**
     * @var bool
     */
    protected $hasViews = true;

    /**
     * @var bool
     */
    protected $hasTranslations = true;

    /**
     * @var array
     */
    protected $providers = [
        EventServiceProvider::class,
        BroadcastServiceProvider::class,
        RouteServiceProvider::class,
        HorizonServiceProvider::class,
    ];
}
