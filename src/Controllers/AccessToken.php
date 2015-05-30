<?php
/**
 * @author  Okechukwu Ugwu
 */

namespace CmeApi\Controllers;

use CmeKernel\Core\CmeKernel;
use Slim\Http\Request;
use CmeApi\AbstractController;
use CmeApi\Helpers\AccessTokenHelper;

class AccessToken extends AbstractController
{
  /**
   * @var $request Request
   */
  private $_request;

  //Time to live in minutes
  private $_expires = 60;

  private $_token;

  protected function _process(Request $request)
  {
    $result['status']  = 'success';
    $result['result']    = null;
    $this->_request    = $request;
    $validApi          = CmeKernel::ApiClient()->validate(
      $request->post('client_key'),
      $request->post('client_secret')
    );
    $result['request'] = $request->post();
    if($validApi)
    {
      $result['result']['oauth'] = [
        'error'         => $this->_getErrors(),
        'access_token'  => $this->_generateAccessToken(),
        'refresh_token' => $this->_generateBaseToken(),
        'expiry_time'       => $this->_getExpiryTimeForToken(),
        'extra'         => '',
      ];
    }
    else
    {
      $result['status']  = 'fail';
      $result['message'] = 'Invalid Client Key';
    }

    return $result;
  }

  /**
   * Generate an Access Token for API Client
   *
   * @return array|bool|string
   */
  private function _generateAccessToken()
  {
    return $this->_generateBaseToken();
  }

  private function _generateBaseToken()
  {
    $clientKey    = $this->_request->post('client_key'); //same as app id
    $clientSecret = $this->_request->post('client_secret');

    $id = [
      'deviceId' => $clientKey,
      'userId'   => $clientSecret
    ];
    //$authCode     = $this->_request->get('auth_code');
    //$grantType    = $this->_request->get('grant_type');

    //TODO: some sort of validation based on the auth_code

    $this->_token = AccessTokenHelper::getCachedToken($clientKey);
    if(!$this->_token)
    {
      $salt = md5(
        $clientKey . $clientKey . $clientSecret . microtime(true)
      );

      $tokenLen = 40;
      if(function_exists('mcrypt_create_iv'))
      {
        $randomData = mcrypt_create_iv(100, MCRYPT_DEV_URANDOM);
      }
      elseif(function_exists('openssl_random_pseudo_bytes'))
      {
        $randomData = openssl_random_pseudo_bytes(100);
      }
      elseif(@file_exists('/dev/urandom'))
      { // Get 100 bytes of random data
        $randomData = file_get_contents('/dev/urandom', false, null, 0, 100)
          . uniqid(mt_rand(), true);
      }
      else
      {
        $randomData = mt_rand() . mt_rand() . mt_rand() . mt_rand()
          . microtime(true) . uniqid(mt_rand(), true);
      }

      $this->_token = substr(hash('sha512', $randomData . $salt), 0, $tokenLen);

      AccessTokenHelper::cacheToken(
        $clientKey,
        $this->_token,
        $this->_expires
      );

      AccessTokenHelper::cacheId(
        $this->_token,
        $id,
        $this->_expires
      );
    }
    return $this->_token;
  }

  private function _getExpiryTimeForToken()
  {
    return date('Y-m-d H:i:s', strtotime('+ ' . $this->_expires . ' minutes'));
  }


  private function _getErrors()
  {
    return [];
  }

  public function requiresAccessToken()
  {
    return false;
  }
}
