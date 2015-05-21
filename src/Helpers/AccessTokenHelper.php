<?php
/**
 * @author  User
 */

namespace CmeApi\Helpers;

use CmeApi\Configs\Config;
use Illuminate\Cache\CacheManager;
use Illuminate\Cache\MemcachedConnector;
use Illuminate\Cache\RedisStore;
use Illuminate\Cache\StoreInterface;
use Illuminate\Redis\Database;

class AccessTokenHelper
{
  private static $_cacheManager;

  public static function cacheToken($clientKey, $token, $expire)
  {
    $cache = self::cacheManager();
    $cache->put(
      'Token:' . $clientKey,
      $token,
      $expire
    );
  }

  public static function cacheId($token, $id, $expire)
  {
    $cache = self::cacheManager();
    $cache->put(
      'ID:' . $token,
      $id,
      $expire
    );
  }

  public static function getCachedToken($clientKey)
  {
    $cache       = self::cacheManager();
    $cachedToken = $cache->get('Token:' . $clientKey);

    if($cachedToken)
    {
      return $cachedToken;
    }

    return false;
  }

  public static function getID($token)
  {
    $cache = self::cacheManager();
    $id    = $cache->get('ID:' . $token);
    if($id)
    {
      return $id;
    }

    return false;
  }

  /**
   * @return StoreInterface
   */
  public static function cacheManager()
  {
    if(self::$_cacheManager == null)
    {
      $config              = [
        'config'              => Config::get('cache'),
        'redis'               => new Database(),
        'memcached.connector' => new MemcachedConnector()
      ];
      self::$_cacheManager = (new CacheManager($config))->driver();
    }

    return self::$_cacheManager;
  }
}
