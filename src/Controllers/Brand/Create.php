<?php

/**
 * @author  oke.ugwu
 */
namespace CmeApi\Controllers\Brand;

use CmeApi\AbstractController;
use CmeData\BrandData;
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
      $data = BrandData::hydrate($request->post());
      if($data->brandName)
      {
        $brandId = CmeKernel::Brand()->create($data);
      }
      else
      {
        throw new \Exception(
          "Brand is missing a name. A name is required to create a brand"
        );
      }

      $result['result']  = ['brandId' => $brandId];
      $result['message'] = 'Brand successfully created.';
    }
    catch(\Exception $e)
    {
      $result['status'] = 'fail';
      $result['error']  = $e->getMessage();
    }

    return $result;
  }
}
