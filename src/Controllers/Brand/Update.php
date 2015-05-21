<?php

/**
 * @author  oke.ugwu
 */
namespace CmeApi\Controllers\Brand;

use CmeApi\AbstractController;
use CmeData\BrandData;
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
      $data = BrandData::hydrate($request->post());
      if($data->id)
      {
        $result['result'] = CmeKernel::Brand()->update($data);
      }
      else
      {
        throw new \Exception(
          "Brand ID is missing a name. An id is required to create a list"
        );
      }

      $result['message'] = 'Brand successfully updated.';
    }
    catch(\Exception $e)
    {
      $result['status'] = 'fail';
      $result['error']  = $e->getMessage();
    }

    return $result;
  }
}
