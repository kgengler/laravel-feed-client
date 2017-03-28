<?php namespace Kgengler\FeedClient;

/**
 * Object representing an RssFeed implementation of feed
 *
 * Class RssFeed
 * @see Feed
 * @package Kgengler\FeedClient
 */
class RssFeed implements Feed {

    private $url;
    private $user;
    private $password;
    private $is_cached;
    private $cache_ttl;
    private $title;
    private $description;
    private $link;
    private $items;

    /**
     * Uses a configuration array to initialize the RssFeed
     * RssFeed constructor.
     * @param $config
     */
    public function __construct($config) {
        $this->url = $config['url'];
        $this->user = isset($config['user']) ? $config['user'] : null;
        $this->password = isset($config['password']) ? $config['password'] : null;
        $this->is_cached = isset($config['cached']) ? $config['cached'] : true;
        $this->cache_ttl = isset($config['cacheTimeout']) ? $config['cacheTimeout'] : 60;

        $xml = null;
        if ($this->is_cached) {
            $xml = FeedUtils::fetchCache($this->url, $this->cache_ttl, $this->user, $this->password);
        } else {
            $xml = FeedUtils::fetchRemote($this->url, $this->user, $this->password);
        }

        if (!$xml->channel) {
            throw new FeedException('Invalid RSS feed.');
        }

        $this->title = $xml->channel->title;
        $this->description = $xml->channel->description;
        $this->link = $xml->channel->link;
        $this->items = FeedUtils::generateFeedItemsFromXml($xml->channel->item);
    }

    /**
     * @see Feed#getTitle()
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @see Feed#getDescription()
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @see Feed#getLink()
     * @return string
     */
    public function getLink() {
        return $this->link;
    }

    /**
     * @see Feed#getItems()
     * @return string
     */
    public function getItems() {
        return $this->items;
    }

    /**
     * Print the RssFeed in a human readable format
     * @return string
     */
    public function __toString() {
        return "RssFeed [title=$this->title, link=$this->link, description=$this->description, items=" . print_r($this->items, true) . "]";
    }
}
