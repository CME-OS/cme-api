<?php

/**
 * @author  oke.ugwu
 */
namespace CmeApi\Controllers\EmailList;

use CmeApi\AbstractController;
use CmeKernel\Core\CmeDatabase;
use CmeKernel\Core\CmeKernel;
use CmeKernel\Data\SubscriberData;
use Slim\Http\Request;

class AddSubscriber extends AbstractController
{

  public function _process(Request $request)
  {
    $result['status']  = 'success';
    $result['result']  = null;
    $result['request'] = $request->post();
    try
    {
      $listId = $request->post('id');
      $post   = $request->post();
      unset($post['id']);
      unset($post['client_key']);
      unset($post['client_secret']);
      unset($post['access_token']);

      /**
       * @var SubscriberData $data
       */
      $data = CmeDatabase::hydrate(new SubscriberData(), $post, false);
      if($listId)
      {
        $result['result'] = CmeKernel::EmailList()->addSubscriber(
          $data,
          $listId
        );
      }
      else
      {
        throw new \Exception(
          "List ID is missing. An id is required to add a subscriber to a list"
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
