<?php

/**
 * @author  Okechukwu Ugwu
 */

namespace CmeApi;

use Slim\Http\Request;
use CmeApi\Interfaces\IController;
use CmeApi\Configs\Config;

class ApiCall
{
  private static $_call;
  private static $_request;

  private function __construct()
  {
  }

  public static function createApiCall(Request $request, $call)
  {
    self::$_request = $request;
    self::$_call    = ltrim($call, "/");
    return new ApiCall();
  }

  public static function getSupportedCalls($callName = null)
  {
    $calls = Config::getRoutes();
    if($callName === null)
    {
      return $calls;
    }
    return \idx($calls, $callName);
  }

  public function isSupported()
  {
    if(self::$_call !== null)
    {
      return self::getSupportedCalls(self::$_call) !== null;
    }
    else
    {
      throw new \Exception('API call not created');
    }
  }

  public function name()
  {
    return '/' . self::$_call;
  }

  /**
   * @return IController
   * @throws \Exception
   */
  public function getController()
  {
    if(self::isSupported())
    {
      $controllerClass = self::getSupportedCalls(self::$_call);
      return new $controllerClass;
    }
    else
    {
      throw new \Exception(sprintf(
        "%s is not a supported TapUp call",
        self::$_call
      ));
    }
  }

  public function canProcess()
  {
    //determine if user can access API based on the client id and secret
    return true;
  }
}
