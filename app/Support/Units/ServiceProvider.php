<?php

namespace Codecasts\Support\Units;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

/**
 * Class ServiceProvider.
 *
 * Units abstract service provider class.
 */
abstract class ServiceProvider extends LaravelServiceProvider
{
    /**
     * @var string Unit name (slug)
     */
    protected $slug;

    /**
     * @var array List of Unit Service Providers to Register
     */
    protected $providers = [];

    /**
     * @var bool Enable views loading on the Unity
     */
    protected $hasViews = false;

    /**
     * @var bool Enable translations loading on the Unity
     */
    protected $hasTranslations = false;

    /**
     * Boot required registering of views and translations.
     */
    public function boot()
    {
        // register unity translations.
        $this->registerTranslations();

        // register unity views.
        $this->registerViews();
    }

    public function register()
    {
        // register unity custom domains.
        $this->registerProviders(collect($this->providers));
    }

    /**
     * Register Unit Custom ServiceProviders.
     *
     * @param Collection $providers
     */
    protected function registerProviders(Collection $providers)
    {
        // loop through providers to be registered.
        $providers->each(function ($providerClass) {
            // register a provider class.
            $this->app->register($providerClass);
        });
    }

    /**
     * Register unity translations.
     */
    protected function registerTranslations()
    {
        if ($this->hasTranslations) {
            $this->loadTranslationsFrom(
                $this->unitPath('Resources/Lang'),
                $this->slug
            );
        }
    }

    /**
     * Register unity views.
     */
    protected function registerViews()
    {
        if ($this->hasViews) {
            $this->loadViewsFrom(
                $this->unitPath('Resources/Views'),
                $this->slug
            );
        }
    }

    /**
     * Detects the unit base path so resources can be proper loaded
     * on child classes.
     *
     * @param string $append
     *
     * @return string
     *
     * @throws
     */
    protected function unitPath($append = null)
    {
        $reflection = new \ReflectionClass($this);

        $realPath = realpath(dirname($reflection->getFileName()).'/../');

        if (!$append) {
            return $realPath;
        }

        return $realPath.'/'.$append;
    }
}
