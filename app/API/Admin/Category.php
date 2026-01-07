<?php
namespace App\API\Admin;

use App\API\BaseAPIController;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class Category extends BaseAPIController
{
  private $categoryModel;

  public function __construct()
  {
    $this->categoryModel = new \App\Models\CategoryModel();
  }

  public function index()
  {
    $type = $this->request->getGet("type");
    $categories = $this->categoryModel->findByType($type);
    return $this->getResponse($categories, ResponseInterface::HTTP_OK);
  }

  public function show($id = null)
  {
    $post = $this->categoryModel->find($id);
    return $this->getResponse($post, ResponseInterface::HTTP_OK);
  }

  private function getSaveData()
  {
    $category = new \App\Entities\Category($this->request->getJSON(true));
    $category->name = mb_url_title($category->description, "-", true);
    return $category;
  }

  public function create()
  {
    try {
      if ($this->categoryModel->insert($this->getSaveData()) === false) {
        return $this->getResponse(
          ["return" => "warning", "message" => errors($this->categoryModel->errors())],
          ResponseInterface::HTTP_OK,
        );
      }

      return $this->getResponse(
        ["return" => "success", "message" => "Cadastro realizado com sucesso"],
        ResponseInterface::HTTP_CREATED,
      );
    } catch (Exception $e) {
      return $this->getResponse(
        ["return" => "danger", "message" => $e->getMessage()],
        ResponseInterface::HTTP_BAD_REQUEST,
      );
    }
  }

  public function update($id = null)
  {
    try {
      if ($this->categoryModel->update($id, $this->getSaveData()) === false) {
        return $this->getResponse(
          ["return" => "warning", "message" => errors($this->categoryModel->errors())],
          ResponseInterface::HTTP_OK,
        );
      }

      return $this->getResponse(
        ["return" => "success", "message" => "Informações atualizadas com sucesso"],
        ResponseInterface::HTTP_CREATED,
      );
    } catch (Exception $e) {
      return $this->getResponse(
        ["return" => "danger", "message" => $e->getMessage()],
        ResponseInterface::HTTP_BAD_REQUEST,
      );
    }
  }

  public function delete($id = null)
  {
    try {
      if ($this->categoryModel->del($id)) {
        return $this->getResponse(
          ["return" => "success", "message" => "Item excluído com sucesso!"],
          ResponseInterface::HTTP_OK,
        );
      }

      return $this->getResponse(
        ["return" => "danger", "message" => "Erro ao tentar excluir. [Error:86][0]"],
        ResponseInterface::HTTP_BAD_REQUEST,
      );
    } catch (Exception $e) {
      return $this->getResponse(
        ["return" => "danger", "message" => $e->getMessage()],
        ResponseInterface::HTTP_BAD_REQUEST,
      );
    }
  }

  public function reorder()
  {
    try {
      $items = $this->request->getJSON(false);
      if ($items) {
        foreach ($items as $key => $item) {
          $this->categoryModel->reorder($item->id, $key);
        }
      }

      return $this->getResponse(
        ["return" => "success", "message" => "Atualizado com sucesso!"],
        ResponseInterface::HTTP_OK,
      );
    } catch (Exception $e) {
      return $this->getResponse(
        ["return" => "danger", "message" => $e->getMessage()],
        ResponseInterface::HTTP_BAD_REQUEST,
      );
    }
  }
}
