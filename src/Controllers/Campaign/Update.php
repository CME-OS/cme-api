<?php

/**
 * @author  oke.ugwu
 */
namespace CmeApi\Controllers\Campaign;

use CmeApi\AbstractController;
use CmeData\CampaignData;
use CmeKernel\Core\CmeKernel;
use Slim\Http\Request;

class Update extends AbstractController
{
  public function _process(Request $request)
  {
    $result['status']  = 'success';
    $result['result']  = null;
    $result['request'] = $request->post();
    try
    {
      $data = CampaignData::hydrate($request->post());
      if($data->id)
      {
        $result['result'] = CmeKernel::Campaign()->update($data);
      }
      else
      {
        throw new \Exception(
          "Campaign ID is missing a name. An id is required to create a list"
        );
      }

      $result['message'] = 'Campaign successfully updated.';
    }
    catch(\Exception $e)
    {
      $result['status'] = 'fail';
      $result['error']  = $e->getMessage();
    }

    return $result;
  }
}
