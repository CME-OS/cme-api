<?php

/**
 * @author  oke.ugwu
 */
namespace CmeApi\Controllers\EmailList;

use CmeApi\AbstractController;
use CmeKernel\Core\CmeDatabase;
use CmeKernel\Core\CmeKernel;
use CmeKernel\Data\ListData;
use Slim\Http\Request;

class Update extends AbstractController
{

  public function _process(Request $request)
  {
    $result['status']  = 'success';
    $result['data']    = null;
    $result['request'] = $request->post();
    try
    {
      /**
       * @var ListData $data
       */
      $data = CmeDatabase::hydrate(new ListData(), $request->post());
      if($data->id)
      {
        CmeKernel::EmailList()->update($data);
      }
      else
      {
        throw new \Exception(
          "List ID is missing a name. An id is required to create a list"
        );
      }

      $result['message'] = 'List successfully updated.';
    }
    catch(\Exception $e)
    {
      $result['status']  = 'fail';
      $result['message'] = $e->getMessage();
    }

    return $result;
  }
}
