<?php namespace Kgengler\FeedClient;

use Illuminate\Support\ServiceProvider;

/**
 * Feed Client Service Provider for Laravel
 *
 * Class FeedClientServiceProvider
 * @package Kgengler\FeedClient
 */
class FeedClientServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the package and alias
     *
     * @return void
     */
    public function boot() {
        $path = __DIR__.'/config/feed-client.php';

        $this->mergeConfigFrom($path, 'feed-client');

        if (function_exists('config_path')) {
            $this->publishes([$path => config_path('feed-client.php')]);
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->app->singleton('Kgengler\FeedClient\FeedFactory', function() {
            return new FeedFactory();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return array('Kgengler\FeedClient\FeedFactory');
    }
}

