<?php namespace Kgengler\FeedClient;

use Cache;
use SimpleXMLElement;

/**
 * Static Utility functions for working with the feeds
 *
 * Class FeedUtils
 * @package Kgengler\FeedClient
 */
final class FeedUtils {

    /**
     * Private constructor to prevent instantiation
     * FeedUtils constructor.
     */
    private function __construct() {
        // Intentionally left blank
    }

    /**
     * Private clone function to prevent instantiation
     */
    private function __clone() {
        // Intentionally left blank
    }

    /**
     * Fetch the feed's XML document, prioritizing the cache
     *
     * @param $url
     * @param $ttl
     * @param $user
     * @param $password
     * @return SimpleXMLElement
     */
    public static function fetchCache($url, $ttl, $user, $password) {

        $data = Cache::remember(self::generateCacheKey($url), $ttl, function() use ($url, $user, $password) {
            return self::fetchRemote($url, $user,$password)->asXML();
        });

        return new SimpleXmlElement($data, LIBXML_NOWARNING | LIBXML_NOERROR);
    }

    /**
     * Generate the FeedItem objects from the XML document
     *
     * @param $xml
     * @return array
     */
    public static function generateFeedItemsFromXml($xml_items) {
        $items = array();
        foreach ($xml_items as $item) {
            // convert to timestamp
            if (isset($item->updated)) {
                $item->timestamp = strtotime($item->updated);
            } elseif (isset($item['dc:date'])) {
                $item->timestamp = strtotime($item['dc:date']);
            } elseif (isset($item->pubDate)) {
                $item->timestamp = strtotime($item->pubDate);
            }
            array_push($items, new FeedItem($item));
        }
        return $items;
    }

    /**
     * Fetch the remote feed and return it as XML
     *
     * @param $url
     * @param $user
     * @param $password
     * @return SimpleXMLElement
     * @throws FeedException
     */
    public static function fetchRemote($url, $user, $password) {
        // Fail fast if we can't make the HTTP request
        if (!extension_loaded('curl')) {
            throw new FeedException('System is missing PHP curl extension');
        }

        $curl = curl_init();

        $curl_options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array("cache-control: no-cache"),
        );

        if (!empty($user) && !empty($password)) {
            $curl_options[CURLOPT_USERPWD] = "$user:$password";
        }

        curl_setopt_array($curl, $curl_options);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        // Something happened with cURL
        if ($err) {
            throw new FeedException("failed to fetch feed: $err");
        }

        $data = trim($response);

        return new SimpleXmlElement($data, LIBXML_NOWARNING | LIBXML_NOERROR);
    }

    /**
     * generate the key we'll use for the local cache
     *
     * @param $url
     * @return string
     */
    public static function generateCacheKey($url) {
        return md5('feed-' . strtolower($url));
    }
}
