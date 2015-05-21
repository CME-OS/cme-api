<?php

/**
 * @author  oke.ugwu
 */
namespace CmeApi\Controllers\EmailList;

use CmeApi\AbstractController;
use CmeKernel\Core\CmeKernel;
use Slim\Http\Request;

class All extends AbstractController
{

  public function _process(Request $request)
  {
    $result['status']  = 'success';
    $result['result']  = null;
    $result['request'] = $request->post();
    try
    {
      $includeDeleted          = $request->post('include_deleted');
      $result['data']['lists'] = CmeKernel::EmailList()->all(
        $includeDeleted
      );
      $result['message']       = 'All lists returned.';
    }
    catch(\Exception $e)
    {
      $result['status']  = 'fail';
      $result['message'] = $e->getMessage();
    }

    return $result;
  }
}
