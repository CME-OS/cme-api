<?php
/**
 * @author  User
 */
namespace CmeApi\Configs;

class Config
{
  private static $_config;

  public static function get($group, $item = null)
  {
    self::loadConfig();
    $return = idx(self::$_config, $group);
    if($item !== null)
    {
      $return = idx(self::$_config[$group], $item);
    }

    return $return;
  }

  public static function getRoutes()
  {
    self::loadConfig();

    $routes = [
      'routes' => [
        'oauth/authorize'        => 'CmeApi\\Controllers\\Authorize',
        'oauth/access_token'     => 'CmeApi\\Controllers\\AccessToken',
        'list/all'               => 'CmeApi\\Controllers\\EmailList\\All',
        'list/get'               => 'CmeApi\\Controllers\\EmailList\\Get',
        'list/exists'            => 'CmeApi\\Controllers\\EmailList\\Exists',
        'list/create'            => 'CmeApi\\Controllers\\EmailList\\Create',
        'list/update'            => 'CmeApi\\Controllers\\EmailList\\Update',
        'list/delete'            => 'CmeApi\\Controllers\\EmailList\\Delete',
        'list/add_subscriber'    => 'CmeApi\\Controllers\\EmailList\\AddSubscriber',
        'list/delete_subscriber' => 'CmeApi\\Controllers\\EmailList\\DeleteSubscriber',
        'list/get_subscriber'    => 'CmeApi\\Controllers\\EmailList\\GetSubscriber',
        'list/get_subscribers'   => 'CmeApi\\Controllers\\EmailList\\GetSubscribers',
        'list/get_campaigns'     => 'CmeApi\\Controllers\\EmailList\\GetCampaigns',
        'campaign/all'           => 'CmeApi\\Controllers\\Campaign\\All',
        'campaign/get'           => 'CmeApi\\Controllers\\Campaign\\Get',
        'campaign/exists'        => 'CmeApi\\Controllers\\Campaign\\Exists',
        'campaign/create'        => 'CmeApi\\Controllers\\Campaign\\Create',
        'campaign/update'        => 'CmeApi\\Controllers\\Campaign\\Update',
        'campaign/delete'        => 'CmeApi\\Controllers\\Campaign\\Delete',
        'brand/all'              => 'CmeApi\\Controllers\\Brand\\All',
        'brand/get'              => 'CmeApi\\Controllers\\Brand\\Get',
        'brand/exists'           => 'CmeApi\\Controllers\\Brand\\Exists',
        'brand/create'           => 'CmeApi\\Controllers\\Brand\\Create',
        'brand/update'           => 'CmeApi\\Controllers\\Brand\\Update',
        'brand/delete'           => 'CmeApi\\Controllers\\Brand\\Delete',
      ]
    ];

    self::$_config = array_merge(self::$_config, $routes);
    return self::$_config['routes'];
  }

  public static function loadConfig()
  {
    if(self::$_config == null)
    {
      self::$_config = include_once API_ROOT . '/../config.php';
    }
  }
}
