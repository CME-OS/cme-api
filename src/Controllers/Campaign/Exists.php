<?php

/**
 * @author  oke.ugwu
 */
namespace CmeApi\Controllers\Campaign;

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
      $campaignId = $request->post('id');
      if($campaignId)
      {
        $result['result'] = CmeKernel::Campaign()->exists($campaignId);
      }
      else
      {
        throw new \Exception(
          "Campaign ID is missing a name. A name is required to check if it exists"
        );
      }
      $result['message'] = 'Campaign exists.';
    }
    catch(\Exception $e)
    {
      $result['status'] = 'fail';
      $result['error']  = $e->getMessage();
    }

    return $result;
  }
}
