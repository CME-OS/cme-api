<?php
/**
 * @author  User
 */

namespace CmeAPi;

use CmeKernel\Core\CmeKernel;
use Slim\Http\Request;
use Slim\Http\Response;
use CmeApi\Helpers\AccessTokenHelper;
use CmeApi\Interfaces\IController;

abstract class AbstractController implements IController
{
  protected $_id;

  public function process(Request $request)
  {
    if(!$this->requiresAccessToken() || ($this->requiresAccessToken(
        ) && $this->_hasValidToken($request))
    )
    {
      $valid = CmeKernel::ApiClient()->validate(
        $request->post('client_key'),
        $request->post('client_secret')
      );
      if($valid)
      {
        $result = $this->_process($request);
      }
      else
      {
        $result['status'] = 'fail';
        $result['error']  = "Invalid Client ID";
      }
    }
    else
    {
      $result['status'] = 'fail';
      $result['error']  = "Invalid access token. Try requesting a new token";
    }
    $response = new Response();
    $response->headers->set('Content-Type', 'application/json');
    $response->setBody(json_encode($result));
    return $response;
  }

  /**
   * Check if access_token sent through in the request is still valid
   *
   * @param Request $request
   *
   * @return bool
   */
  private function _hasValidToken(Request $request)
  {
    $this->_id = AccessTokenHelper::getID(
      $request->post('access_token')
    );

    return $this->_id;
  }

  abstract protected function _process(Request $request);

  public function requiresAccessToken()
  {
    return true;
  }
}
