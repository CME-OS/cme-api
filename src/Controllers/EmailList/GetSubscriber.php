<?php

/**
 * @author  oke.ugwu
 */
namespace CmeApi\Controllers\EmailList;

use CmeApi\AbstractController;
use CmeKernel\Core\CmeKernel;
use Slim\Http\Request;

class GetSubscriber extends AbstractController
{

  public function _process(Request $request)
  {
    $result['status']  = 'success';
    $result['result']    = null;
    $result['request'] = $request->post();
    try
    {
      $listId       = $request->post('id');
      $subscriberId = $request->post('subscriber_id');
      if($listId)
      {
        $result['result']['subscriber'] = CmeKernel::EmailList()->getSubscriber(
          $subscriberId,
          $listId
        );
      }
      else
      {
        throw new \Exception(
          "List ID is missing. An id is required to get subscriber from a list"
        );
      }
      $result['message'] = 'Subscriber successfully retrieved.';
    }
    catch(\Exception $e)
    {
      $result['status']  = 'fail';
      $result['message'] = $e->getMessage();
    }

    return $result;
  }
}
