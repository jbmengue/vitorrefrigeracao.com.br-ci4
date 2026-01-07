<?php
namespace App\API;

use App\API\BaseAPIController;
use CodeIgniter\HTTP\ResponseInterface;

class Post extends BaseAPIController
{
  private $PostModel;
  private $limitPage = 5;

  public function __construct()
  {
    $this->PostModel = new \App\Models\PostModel();
  }

  public function index()
  {
    $type = (string) $this->getQueryParam("type");
    $page = $this->getQueryParam("page");
    $limit = $this->getQueryParam("limit");
    if ($page !== null) {
      $this->PostModel->offset(!empty($page && $page !== "all"))
        ? (int) $page * $this->limitPage
        : 0;
    }
    $this->PostModel->limit(!empty($limit) ? $limit : $this->limitPage);

    return $this->getResponse(
      $this->PostModel->onlyActive()->findByType(!empty($type) ? $type : null),
      ResponseInterface::HTTP_OK,
    );
  }

  public function bySlug()
  {
    $type = (string) $this->getQueryParam("type");
    $slug = (string) $this->getQueryParam("slug");
    return $this->getResponse(
      $this->PostModel->onlyActive()->findBySlug($type, $slug),
      ResponseInterface::HTTP_OK,
    );
  }
}
