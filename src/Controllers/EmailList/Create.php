<?php

/**
 * @author  oke.ugwu
 */
namespace CmeApi\Controllers\EmailList;

use CmeApi\AbstractController;
use CmeData\ListData;
use CmeKernel\Core\CmeKernel;
use Slim\Http\Request;

class Create extends AbstractController
{
  public function _process(Request $request)
  {
    $result['status']  = 'success';
    $result['result']    = null;
    $result['request'] = $request->post();
    try
    {
      $data = ListData::hydrate($request->post());
      if($data->name)
      {
        $listId = CmeKernel::EmailList()->create($data);
      }
      else
      {
        throw new \Exception(
          "List is missing a name. A name is required to create a list"
        );
      }

      $result['result']    = ['listId' => $listId];
      $result['message'] = 'List successfully created.';
    }
    catch(\Exception $e)
    {
      $result['status']  = 'fail';
      $result['error'] = $e->getMessage();
    }

    return $result;
  }
}
