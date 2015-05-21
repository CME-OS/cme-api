<?php

/**
 * @author  oke.ugwu
 */
namespace CmeApi\Controllers\Campaign;

use CmeApi\AbstractController;
use CmeKernel\Core\CmeKernel;
use Slim\Http\Request;

class Delete extends AbstractController
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
        $result['result']  = CmeKernel::Campaign()->delete($campaignId);
        $result['message'] = 'Campaign successfully deleted.';
      }
      else
      {
        throw new \Exception("Campaign ID must be specified");
      }
    }
    catch(\Exception $e)
    {
      $result['status'] = 'fail';
      $result['error']  = $e->getMessage();
    }

    return $result;
  }
}
