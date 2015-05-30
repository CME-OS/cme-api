<?php

/**
 * @author  oke.ugwu
 */
namespace CmeApi\Controllers\Analytics;

use CmeApi\AbstractController;
use CmeKernel\Core\CmeKernel;
use CmeKernel\Enums\EventType;
use Slim\Http\Request;

class GetLastEvents extends AbstractController
{

  public function _process(Request $request)
  {
    $result['status']  = 'success';
    $result['result']  = null;
    $result['request'] = $request->post();
    try
    {
      $eventType                   = $request->post('event_type');
      $result['result']['campaigns'] = CmeKernel::Analytics()->getLastXOfEvent(
        EventType::fromValue($eventType),
        $request->post('campaign_id')
      );
      $result['message']           = $eventType . ' Events returned.';
    }
    catch(\Exception $e)
    {
      $result['status'] = 'fail';
      $result['error']  = $e->getMessage();
    }

    return $result;
  }
}
