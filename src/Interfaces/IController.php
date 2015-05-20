<?php
/**
 * @author  User
 */

namespace CmeApi\Interfaces;


use Slim\Http\Request;
use Slim\Http\Response;

interface IController {
  /**
   * @param Request $request
   *
   * @return Response $response
   */
  public function process(Request $request);
}
