<?php

/**
 * @author  oke.ugwu
 */
namespace CmeApi\Controllers\Analytics;

use CmeApi\AbstractController;
use CmeData\CampaignEventData;
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
      $data = CampaignEventData::hydrate($request->post());
      if($data->eventType)
      {
        $eventId = CmeKernel::Campaign()->create($data);
      }
      else
      {
        throw new \Exception(
          "Request is missing a event type. A event type is required"
        );
      }

      $result['result']  = ['eventId' => $eventId];
      $result['message'] = 'Campaign Event successfully created.';
    }
    catch(\Exception $e)
    {
      $result['status'] = 'fail';
      $result['error']  = $e->getMessage();
    }

    return $result;
  }
}
