# Feed Client Laravel Service Provider

[![Packagist](https://img.shields.io/packagist/v/kgengler/feed-client.svg)](https://packagist.org/packages/kgengler/feed-client)

> This branch is for Laravel 5.x development, there is no stable version
> available yet
> For Laravel 4.x see https://github.com/kgengler/laravel-feed-client/tree/v4.x

An Atom and RSS feed client for the Laravel Framework

## Installation

Add the following line to the `require` section of `composer.json`:

```json
{
    "require": {
        "kgengler/feed-client": "5.*"
    }
}
```

Run `composer update`.

## Configuration

Find the providers key in your app/config/app.php and register the Feed Client Service Provider.

```php
'providers' => array(
    // ...
    'Kgengler\FeedClient\FeedClientServiceProvider',
)
```

Find the aliases key in your app/config/app.php and add the Feed Client facade alias.

```php
'aliases' => array(
    // ...
    'FeedClient' => 'Kgengler\FeedClient\FeedClientFacade'
)
```

Publish the package configuration using Artisan.

```
php artisan config:publish
```

Open the configuration file in app/config/feed-client.php, and add the feed 
you need to access

```php
<?php
// app/config/feed-client.php

return array(
    // The `laravel` key here is used to fetch the feed later. You can specify multiple
    // feeds, just use another key.
    'laravel' => array(
        
        // Feed type, either `atom` or `rss`
        // Required
        // Default: none
        'type'          => 'atom',
        
        // Url of the feed
        // Required
        // Default: none
        'url'           => 'https://github.com/laravel/laravel/commits/master.atom',
        
        // username required to access feed
        // Optional
        // Default: null
        'user'          => null,
        
        // password required to access feed
        // Optional
        // Default: null
        'password'      => null,
        
        // whether or not to cache the feed locally. I would recommend leaving this
        // on, unless you plan on caching it yourself. It will use whatever cache
        // driver you have specified for your application.
        // Optional
        // Default: true
        'cached'        => true,
        
        // time in minutes to cache feed
        // Optional
        // Default: 60
        'cacheTimeout'  => 60
    )
);
```

## Usage

Fetch the client from the Laravel IOC Container and get the feed 
with the key you provided in the configuration file:

```php
$feed_client = App::make('feed-client');
$feed = $feed_client->get('laravel');

// or with the Facade
$feed = FeedClient::get('laravel');
```

Access methods to get the information from the feed:

```php
$feed->getTitle(); // Feed Title
$feed->getDescription(); // Feed Description
$feed->getLink(); // Link to feed

$feed_items = $feed->getItems(); // Items in feed

// Feed items are given as a collection of FeedItem objects
foreach($feed_items as $item) {
    $item->getTitle(); // Item Title
    $item->getTime(); // Publication Time as DateTime object
    $item->getLink(); // Get link for Item
    $item->getDescription(); // Item Description
}
```
