<?php

namespace Codecasts\Units\Auth\Providers;

use Codecasts\Support\Units\ServiceProvider;

/**
 * Class UnitServiceProvider.
 *
 * Auth unit service provider file.
 */
class UnitServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $slug = 'auth';

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
        AuthServiceProvider::class,
        EventServiceProvider::class,

        RouteServiceProvider::class,
    ];
}
