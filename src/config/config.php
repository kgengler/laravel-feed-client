<?php

return array(
    'cnn'       => array(
        'type'          => 'rss',
        'url'           => 'http://rss.cnn.com/rss/cnn_world.rss',
        'user'          => null,
        'password'      => null,
        'cached'        => true,
        'cacheTimeout'  => 60
    ),
    'laravel'   => array(
        'type'          => 'atom',
        'url'           => 'https://github.com/laravel/laravel/commits/master.atom',
        'user'          => null,
        'password'      => null,
        'cached'        => true,
        'cacheTimeout'  => 60
    )
);
