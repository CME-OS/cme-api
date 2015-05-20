<?php
/**
 * @author  User
 */

namespace CmeApi\Controllers;

use Slim\Http\Request;
use CmeApi\AbstractController;

class Authorize extends AbstractController
{
  protected function _process(Request $request)
  {
    $result = [];

    return $result;
  }

  public function requiresAccessToken()
  {
    return false;
  }
}
