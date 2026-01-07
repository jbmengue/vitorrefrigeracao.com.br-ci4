<?php
namespace App\Filters;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\RequestTrait;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Exception;

class JWTAuthenticationFilter implements FilterInterface
{
  use RequestTrait;

  public function before(RequestInterface $request, $arguments = null)
  {
    $authenticationHeader = $request->getServer("HTTP_AUTHORIZATION");

    try {
      helper("jwt");
      $encodeToken = getJWTFromRequest($authenticationHeader);
      validateJWTFromRequest($encodeToken);
    } catch (Exception $e) {
      return Services::response()->setJSON([
        "error" => $e->getMessage(),
      ]);
    }
  }

  public function after(
    RequestInterface $request,
    ResponseInterface $response,
    $arguments = null,
  ) {}
}
