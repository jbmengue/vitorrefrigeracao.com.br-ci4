<?php
namespace App\API;

use App\API\BaseAPIController;
use CodeIgniter\HTTP\ResponseInterface;

class TechnicalServices extends BaseAPIController
{
  private \App\Models\TechnicalServicesModel $technicalServicesModel;

  public function __construct()
  {
    $this->technicalServicesModel = new \App\Models\TechnicalServicesModel();
  }

  public function index()
  {
    return $this->getResponse(
      $this->technicalServicesModel->onlyActive()->getServices(),
      ResponseInterface::HTTP_OK,
    );
  }
}
