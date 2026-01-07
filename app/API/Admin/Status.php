<?php
namespace App\API\Admin;

use App\API\BaseAPIController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class Status extends BaseAPIController
{
  use ResponseTrait;

  private $statusModel;

  public function __construct()
  {
    $this->statusModel = new \App\Models\StatusModel();
  }

  public function index()
  {
    $departament = $this->request->getGet("departament");
    $status = $this->statusModel->findByDepartament($departament);
    return $this->getResponse($status, ResponseInterface::HTTP_OK);
  }
}
