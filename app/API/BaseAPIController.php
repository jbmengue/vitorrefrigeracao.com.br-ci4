<?php

namespace App\API;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\Validation\Exceptions\ValidationException;
use Config\Services;

class BaseAPIController extends ResourceController
{
  protected $helpers = ["message"];
  protected $format = "json";

  /**
   * Constructor.
   *
   * @param RequestInterface  $request
   * @param ResponseInterface $response
   * @param LoggerInterface   $logger
   */
  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger,
  ) {
    // Do Not Edit This Line
    parent::initController($request, $response, $logger);
  }

  public function getResponse($responseBody, int $code = ResponseInterface::HTTP_OK)
  {
    return $this->respond($responseBody, $code);
  }

  protected function getQueryParam(string $key, mixed $default = null): mixed
{
    /** @var IncomingRequest $request */
    $request = $this->request;
    return $request->getVar($key) ?? $default;
}

  public function getRequestInput(IncomingRequest $request)
  {
    $input = $request->getPost();
    if (empty($input)) {
      $input = json_decode($request->getBody(), true);
    }

    return $input;
  }

  public function validateRequest($input, array $rules, array $messages = [])
  {
    $this->validator = Services::Validation()->setRules($rules);
    if (is_string($rules)) {
      $validation = config("validation");
      if (!isset($validation->$rules)) {
        throw ValidationException::forRuleNotFound($rules);
      }

      if (!$messages) {
        $errorName = $rules . "_errors";
        $messages = $validation->$errorName ?? [];
      }

      $rules = $validation->rules;
    }

    return $this->validator->setRules($rules, $messages)->run($input);
  }
}
