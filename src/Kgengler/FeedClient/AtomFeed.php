<?php namespace Kgengler\FeedClient;

/**
 * Object representing an AtomFeed implementation of feed
 *
 * Class RssFeed
 * @see Feed
 * @package Kgengler\FeedClient
 */
class AtomFeed implements Feed {

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
     * Uses a configuration array to initialize the AtomFeed
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

        $namespaces = $xml->getDocNamespaces();
        if (!in_array('http://www.w3.org/2005/Atom', $namespaces) && !in_array('http://purl.org/atom/ns#', $namespaces)) {
            throw new FeedException('Invalid Atom feed.');
        }

        $this->title = $xml->title;
        $this->description = $xml->description;
        $this->link = $xml->link;
        $this->items = FeedUtils::generateFeedItemsFromXml($xml->entry);
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
     * Print the AtomFeed in a human readable format
     * @return string
     */
    public function __toString() {
        return "AtomFeed [title=$this->title, link=$this->link, description=$this->description, items=" . print_r($this->items, true) . "]";
    }
}
