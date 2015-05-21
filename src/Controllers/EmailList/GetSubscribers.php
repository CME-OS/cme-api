<?php

/**
 * @author  oke.ugwu
 */
namespace CmeApi\Controllers\EmailList;

use CmeApi\AbstractController;
use CmeKernel\Core\CmeKernel;
use Slim\Http\Request;

class GetSubscribers extends AbstractController
{

  public function _process(Request $request)
  {
    $result['status']  = 'success';
    $result['result']    = null;
    $result['request'] = $request->post();
    try
    {
      $listId = $request->post('id');
      $offset = $request->post('offset', 0);
      $limit  = $request->post('limit', 1000);
      if($listId)
      {
        $result['result']['subscribers'] = CmeKernel::EmailList()->getSubscribers(
          $listId,
          $offset,
          $limit
        );
      }
      else
      {
        throw new \Exception(
          "List ID is missing. An id is required to get subscribers from a list"
        );
      }
      $result['message'] = 'Subscribers successfully retrieved.';
    }
    catch(\Exception $e)
    {
      $result['status']  = 'fail';
      $result['message'] = $e->getMessage();
    }

    return $result;
  }
}
