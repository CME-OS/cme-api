<?php

/**
 * @author  oke.ugwu
 */
namespace CmeApi\Controllers\EmailList;

use CmeApi\AbstractController;
use CmeKernel\Core\CmeKernel;
use Slim\Http\Request;

class Get extends AbstractController
{
  public function _process(Request $request)
  {
    $result['status']  = 'success';
    $result['data']    = null;
    $result['request'] = $request->post();
    try
    {
      $listId = $request->post('id');
      if($listId)
      {
        $result['data']['list'] = CmeKernel::EmailList()->get($listId);
      }
      else
      {
        throw new \Exception(
          "List ID is missing a name. A name is required to create a list"
        );
      }
      $result['message'] = 'List successfully created.';
    }
    catch(\Exception $e)
    {
      $result['status']  = 'fail';
      $result['message'] = $e->getMessage();
    }

    return $result;
  }

  public function requiresAccessToken()
  {
    return true;
  }
}
