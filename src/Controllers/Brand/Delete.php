<?php

/**
 * @author  oke.ugwu
 */
namespace CmeApi\Controllers\Brand;

use CmeApi\AbstractController;
use CmeKernel\Core\CmeKernel;
use Slim\Http\Request;

class Delete extends AbstractController
{
  public function _process(Request $request)
  {
    $result['status']  = 'success';
    $result['result']    = null;
    $result['request'] = $request->post();
    try
    {
      $brandId = $request->post('id');
      if($brandId)
      {
        $result['result'] = CmeKernel::Brand()->delete($brandId);
        $result['message'] = 'Brand successfully deleted.';
      }
      else
      {
        throw new \Exception("Brand ID must be specified");
      }
    }
    catch(\Exception $e)
    {
      $result['status']  = 'fail';
      $result['error'] = $e->getMessage();
    }

    return $result;
  }
}
