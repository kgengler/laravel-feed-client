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
        $this->package('kgengler/rss-client', 'feed-client');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->app->bind('feed-client', function () {
            return new FeedFactory();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return array('feed-client');
    }
}
