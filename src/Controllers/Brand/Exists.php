<?php

/**
 * @author  oke.ugwu
 */
namespace CmeApi\Controllers\Brand;

use CmeApi\AbstractController;
use CmeKernel\Core\CmeKernel;
use Slim\Http\Request;

class Exists extends AbstractController
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
        $result['result'] = CmeKernel::Brand()->exists($brandId);
      }
      else
      {
        throw new \Exception(
          "Brand ID is missing a name. A name is required to check if it exists"
        );
      }
      $result['message'] = 'Brand exists.';
    }
    catch(\Exception $e)
    {
      $result['status']  = 'fail';
      $result['error'] = $e->getMessage();
    }

    return $result;
  }
}
