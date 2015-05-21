<?php
/**
 * @author  oke.ugwu
 */
return [
  'db'    => [
    'host'     => 'localhost',
    'user'     => 'root',
    'password' => '',
    'dbname'   => 'cme'
  ],
  'cache' => [
    'cache.driver' => 'memcached',
    //Supported: "file", "database", "apc", "memcached", "redis", "array"
    'cache.path'   => '',
    //only set this if cache.driver is set to file
    'cache.prefix' => 'cme',
    'memcached'    => [
      ['host' => 'localhost', 'port' => 11211, 'weight' => 100],
    ],
    'redis'        => [
      'cluster' => false,
      'default' => array(
        'host'     => '127.0.0.1',
        'port'     => 6379,
        'database' => 0,
      ),
    ]
  ]
];
