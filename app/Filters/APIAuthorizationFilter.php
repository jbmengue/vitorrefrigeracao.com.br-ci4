<?php
namespace App\Filters;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\RequestTrait;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Exception;

class APIAuthorizationFilter implements FilterInterface
{
  use RequestTrait;

  public function before(RequestInterface $request, $arguments = null)
  {
    try {
      $referer = true;
      if (getenv("CI_ENVIRONMENT") === "production") {
        $referer = strpos($request->getServer("HTTP_REFERER"), getenv("app.baseURL"));
      }
      $apiKey = $request->getServer("HTTP_APIKEY");
      $requestedWith = $request->getServer("HTTP_X_REQUESTED_WITH");

      if (
        $referer === false ||
        $apiKey !== sha1(getenv("app.apiAuthorizationKey")) ||
        $requestedWith !== "XMLHttpRequest"
      ) {
        return $this->returnError("UNAUTHORIZED");
      }
    } catch (Exception $e) {
      return $this->returnError($e->getMessage());
    }
  }

  public function after(
    RequestInterface $request,
    ResponseInterface $response,
    $arguments = null,
  ) {}

  private function returnError($message)
  {
    return Services::response()
      ->setJSON(["return" => "danger", "message" => $message])
      ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
  }
}
