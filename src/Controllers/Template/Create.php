<?php

/**
 * @author  oke.ugwu
 */
namespace CmeApi\Controllers\Template;

use CmeApi\AbstractController;
use Slim\Http\Request;

class Create extends AbstractController
{

  public function _process(Request $request)
  {

  }

  public function requiresAccessToken()
  {
    return true;
  }
}
