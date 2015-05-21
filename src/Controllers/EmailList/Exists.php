<?php

/**
 * @author  oke.ugwu
 */
namespace CmeApi\Controllers\EmailList;

use CmeApi\AbstractController;
use CmeKernel\Core\CmeKernel;
use Slim\Http\Request;

class Exists extends AbstractController
{
  public function _process(Request $request)
  {
    $result['status']  = 'success';
    $result['result']  = null;
    $result['request'] = $request->post();
    try
    {
      $listId = $request->post('id');
      if($listId)
      {
        $result['result'] = CmeKernel::EmailList()->exists($listId);
      }
      else
      {
        throw new \Exception(
          "List ID is missing a name. A name is required to check if it exists"
        );
      }
      $result['message'] = 'List exists.';
    }
    catch(\Exception $e)
    {
      $result['status']  = 'fail';
      $result['error'] = $e->getMessage();
    }

    return $result;
  }
}
