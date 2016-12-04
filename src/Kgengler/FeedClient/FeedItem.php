<?php namespace Kgengler\FeedClient;

use DateTime;

/**
 * Object representing an item present in a feed
 *
 * Class FeedItem
 * @package Kgengler\FeedClient
 */
class FeedItem {

    private $title;
    private $link;
    private $time;
    private $description;

    public function __construct($item) {

        \Log::debug(print_r($item, true));
        $this->title = $item->title;
        $this->link = $item->link;
        $this->description = $item->description;

        $date = new DateTime();
        $date->setTimestamp(intval($item->timestamp));
        $this->time = $date;
    }

    /**
     * Get the item title
     *
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * get the item link
     *
     * @return mixed
     */
    public function getLink() {
        return $this->link;
    }

    /**
     * get the publish time as a DateTime object
     *
     * @return DateTime
     */
    public function getTime() {
        return $this->time;
    }

    /**
     * Get the description of the FeedItem
     * @return mixed
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Print the FeedItem in a human readable format
     * @return string
     */
    public function __toString() {
        return "FeedItem [title=$this->title, link=$this->link, timestamp=$this->timestamp, description=$this->description";
    }
}
