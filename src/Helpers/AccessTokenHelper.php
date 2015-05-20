<?php
/**
 * @author  User
 */

namespace CmeApi\Helpers;

class AccessTokenHelper
{
  private static $_memcache;

  public static function cacheToken($deviceId, $token, $expire)
  {
    $cache = self::memcache();
    $cache->add(
      'Token:' . $deviceId,
      $token,
      MEMCACHE_COMPRESSED,
      $expire
    );
  }

  public static function cacheId($token, $id, $expire)
  {
    $cache = self::memcache();
    $cache->add(
      'ID:' . $token,
      $id,
      MEMCACHE_COMPRESSED,
      $expire
    );
  }

  public static function getCachedToken($deviceId)
  {
    $cache       = self::memcache();
    $cachedToken = $cache->get('Token:' . $deviceId);

    if($cachedToken)
    {
      return $cachedToken;
    }

    return false;
  }

  public static function getID($token)
  {
    $cache = self::memcache();
    $id    = $cache->get('ID:' . $token);
    if($id)
    {
      return $id;
    }

    return false;
  }

  public static function memcache()
  {
    if(self::$_memcache == null)
    {
      self::$_memcache = new \Memcache();
      try
      {
        self::$_memcache->connect('localhost', 11211);
      }
      catch(\Exception $e)
      {
        throw new \Exception("Could not connect to memcache");
      }
    }

    return self::$_memcache;
  }
}
