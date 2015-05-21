<?php

/**
 * @author  oke.ugwu
 */
namespace CmeApi\Controllers\Brand;

use CmeApi\AbstractController;
use CmeKernel\Core\CmeKernel;
use Slim\Http\Request;

class Get extends AbstractController
{
  public function _process(Request $request)
  {
    $result['status']  = 'success';
    $result['result']  = null;
    $result['request'] = $request->post();
    try
    {
      $brandId = $request->post('id');
      if($brandId)
      {
        $result['result']['brand'] = CmeKernel::Campaign()->get($brandId);
      }
      else
      {
        throw new \Exception(
          "Brand ID is missing a name. A name is required to create a list"
        );
      }
      $result['message'] = 'Brand successfully retrieved.';
    }
    catch(\Exception $e)
    {
      $result['status']  = 'fail';
      $result['error'] = $e->getMessage();
    }

    return $result;
  }
}
