<?php

/**
 * @author  oke.ugwu
 */
namespace CmeApi\Controllers\EmailList;

use CmeApi\AbstractController;
use CmeKernel\Core\CmeKernel;
use Slim\Http\Request;

class GetCampaigns extends AbstractController
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
        $result['result']['campaigns'] = CmeKernel::EmailList()->campaigns(
          $listId
        );
      }
      else
      {
        throw new \Exception(
          "List ID is missing. An id is required to get campaigns using a list"
        );
      }
      $result['message'] = 'Campaigns successfully retrieved.';
    }
    catch(\Exception $e)
    {
      $result['status']  = 'fail';
      $result['error'] = $e->getMessage();
    }

    return $result;
  }
}
