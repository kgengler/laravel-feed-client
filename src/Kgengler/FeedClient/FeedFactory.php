<?php namespace Kgengler\FeedClient;

use Config;

/**
 * Creates instances of the appropriate Feed implementation as needed
 *
 * Class FeedFactory
 * @package Kgengler\FeedClient
 */
class FeedFactory {

    private $feeds;

    public function __construct() {
        $this->feeds = array();
    }

    /**
     * Check if the feed is already present in the internal map
     *
     * @param $key
     * @return bool
     */
    public function contains($key) {
        return isset($this->feeds[$key]);
    }

    /**
     * return the number of feeds initialized
     *
     * @return int
     */
    public function size() {
        return count($this->feeds);
    }

    /**
     * get the feed for the given key
     *
     * @param $key
     * @return Feed
     */
    public function get($key) {
        if (!$this->contains($key)) {
            $this->feeds[$key] = $this->createFeed($key);
        }

        return $this->feeds[$key];
    }

    /**
     * Add a new feed to the internal map with the given key
     *
     * @param $key
     * @param $value
     */
    public function put($key, $value) {
        $this->feeds[$key] = $value;
    }

    /**
     * Get the collection containing all the feeds
     *
     * @return array
     */
    public function all() {
        return $this->feeds;
    }

    /**
     * create a new instance of a Feed using configuration for the provided key
     *
     * @param $key
     * @return RssFeed
     * @throws FeedClientException
     */
    private function createFeed($key) {
        $config = Config::get('feed-client::' . $key);

        if (isset($config) && !empty($config)) {
            $type = isset($config['type']) ? $config['type'] : '';

            if ($type == 'rss') {
                return new RssFeed($config);
            } else if ($type = 'atom') {
                return new AtomFeed($config);
            }

            throw new FeedClientException('Unsupported feed type ' . $type);
        } else {
            throw new FeedClientException('No configuration for ' . $key);
        }
    }
}
