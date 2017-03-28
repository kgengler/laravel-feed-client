<?php namespace Kgengler\FeedClient;

/**
 * Interface that all feed types will implement
 *
 * Interface Feed
 * @package Kgengler\FeedClient
 */
interface Feed {

    /**
     * Get the title of the feed
     *
     * @return string
     */
    public function getTitle();

    /**
     * Get the description of the feed
     *
     * @return string
     */
    public function getDescription();

    /**
     * Get the link to the feed
     *
     * @return string
     */
    public function getLink();

    /**
     * Get a collection of all the FeedItems for the Feed
     *
     * @return collection of FeedItems
     */
    public function getItems();
}
