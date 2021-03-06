<?php

/**
 * @author  oke.ugwu
 */
namespace CmeApi\Controllers\Campaign;

use CmeApi\AbstractController;
use CmeData\CampaignData;
use CmeKernel\Core\CmeKernel;
use Slim\Http\Request;

class Create extends AbstractController
{
  public function _process(Request $request)
  {
    $result['status']  = 'success';
    $result['result']  = null;
    $result['request'] = $request->post();
    try
    {
      $data = CampaignData::hydrate($request->post());
      if($data->name)
      {
        $campaignId = CmeKernel::Campaign()->create($data);
      }
      else
      {
        throw new \Exception(
          "Campaign is missing a name. A name is required to create a campaign"
        );
      }

      $result['result']  = ['campaignId' => $campaignId];
      $result['message'] = 'Campaign successfully created.';
    }
    catch(\Exception $e)
    {
      $result['status'] = 'fail';
      $result['error']  = $e->getMessage();
    }

    return $result;
  }
}
