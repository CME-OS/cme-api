<?php

/**
 * @author  oke.ugwu
 */
namespace CmeApi\Controllers\EmailList;

use CmeApi\AbstractController;
use CmeKernel\Core\CmeKernel;
use Slim\Http\Request;

class DeleteSubscriber extends AbstractController
{

  public function _process(Request $request)
  {
    $result['status']  = 'success';
    $result['data']    = null;
    $result['request'] = $request->post();
    try
    {
      $listId       = $request->post('id');
      $subscriberId = $request->post('subscriber_id');
      if($listId)
      {
        CmeKernel::EmailList()->deleteSubscriber($subscriberId, $listId);
      }
      else
      {
        throw new \Exception(
          "List ID is missing. An id is required to delete a subscriber from a list"
        );
      }
      $result['message'] = 'Subscriber successfully deleted.';
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
    return false;
  }
}
