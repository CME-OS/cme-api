<?php
include __DIR__ . '/../vendor/autoload.php';
use Slim\Slim;
use CmeApi\ApiCall;
use CmeApi\Configs\Config;

define('API_ROOT', __DIR__);

Slim::registerAutoloader();

$app = new Slim();
$app->config('debug', true);
$requested = isset($requested) ? $requested : null;
$call      = ltrim($app->request()->params('call', $requested), "/");
if($app->request->isPost())
{
  //check that API request is
  $apiCall = ApiCall::createApiCall($app->request(), $call);
  if($apiCall->isSupported() && $apiCall->canProcess())
  {
    $app->post(
      $apiCall->name(),
      function () use ($app, $apiCall)
      {
        //initial CME Kernel
        $initData             = new \CmeKernel\Data\InitData();
        $initData->dbName     = Config::get('db', 'dbname');
        $initData->dbUsername = Config::get('db', 'user');
        $initData->dbPassword = Config::get('db', 'password');
        $initData->dbHost     = Config::get('db', 'host');
        \CmeKernel\Core\CmeKernel::init($initData);

        $controller    = $apiCall->getController();
        $response      = $controller->process($app->request());
        $app->response = $response;
      }
    );
  }
  else
  {
    $app->post(
      '/' . $call,
      function () use ($app)
      {
        $response = $app->response();
        $response->headers->set('Content-Type', 'application/json');

        $return['status']  = 'error';
        $return['message'] = 'Unsupported Call';
        $return['request'] = $app->request->post();

        $response->setBody(json_encode($return));
      }
    );
  }
}
else
{
  $app->map(
    '/' . $call,
    function () use ($app)
    {
      $response = $app->response();
      $response->headers->set('Content-Type', 'application/json');

      $return['status']  = 'error';
      $return['message'] = 'This API only supports POST method';
      $return['request'] = $app->request->params();

      $response->setBody(json_encode($return));
    }
  )->via('GET', 'POST');
}

$app->run();
