<?php namespace Kgengler\FeedClient;

use Illuminate\Support\Facades\Facade;

/**
 * Facade for easy access to the FeedFactory
 *
 * @package Kgengler\FeedClient
 */
class FeedClientFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'feed-client';
    }
}
