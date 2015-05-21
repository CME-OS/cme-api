<?php

/**
 * @author  oke.ugwu
 */
namespace CmeApi\Controllers\Campaign;

use CmeApi\AbstractController;
use CmeKernel\Core\CmeKernel;
use Slim\Http\Request;

class Get extends AbstractController
{
  public function _process(Request $request)
  {
    $result['status']  = 'success';
    $result['result']  = null;
    $result['request'] = $request->post();
    try
    {
      $campaignId = $request->post('id');
      if($campaignId)
      {
        $result['result']['campaign'] = CmeKernel::Campaign()->get($campaignId);
      }
      else
      {
        throw new \Exception(
          "Campaign ID is missing a name. A name is required to create a list"
        );
      }
      $result['message'] = 'Campaign successfully retrieved.';
    }
    catch(\Exception $e)
    {
      $result['status'] = 'fail';
      $result['error']  = $e->getMessage();
    }

    return $result;
  }
}
