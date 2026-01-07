<?php
namespace App\API\Admin;

use App\API\BaseAPIController;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class Post extends BaseAPIController
{
  private $postModel;

  public function __construct()
  {
    $this->postModel = new \App\Models\PostModel();
  }

  public function index()
  {
    $type = $this->request->getGet("type");
    $posts = $this->postModel->findByType($type);
    return $this->getResponse($posts, ResponseInterface::HTTP_OK);
  }

  public function show($id = null)
  {
    $post = $this->postModel->find($id);
    return $this->getResponse($post, ResponseInterface::HTTP_OK);
  }

  public function categories($id = null)
  {
    $postsCategoriesModel = new \App\Models\PostCategoryModel();
    $categories = $postsCategoriesModel->findCategoriesByPost($id);
    return $this->getResponse($categories, ResponseInterface::HTTP_OK);
  }

  private function getSaveData()
  {
    $post = new \App\Entities\Post();
    $post->fill($this->request->getJSON(true));
    return $post;
  }

  public function create()
  {
    try {
      $postSaveData = $this->getSaveData();
      if ($this->postModel->insert($postSaveData) === false) {
        return $this->getResponse(
          ["return" => "warning", "message" => errors($this->postModel->errors())],
          ResponseInterface::HTTP_OK,
        );
      }

      $this->postsCategories($this->postModel->getInsertID(), $postSaveData->categories);

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
      $postSaveData = $this->getSaveData();
      if ($this->postModel->update($id, $postSaveData) === false) {
        return $this->getResponse(
          ["return" => "warning", "message" => errors($this->postModel->errors())],
          ResponseInterface::HTTP_OK,
        );
      }

      $this->postsCategories($id, $postSaveData->categories);

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
      if ($this->postModel->delete($id)) {
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
          $this->postModel->reorder($item->id, $key);
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

  private function postsCategories($postId = null, $categories = null)
  {
    try {
      if ($postId) {
        $postsCategoriesModel = new \App\Models\PostCategoryModel();
        $postsCategoriesModel->delete($postId);

        if (!empty($categories) && is_array($categories)) {
          $postCategories = new \App\Entities\PostCategory();
          foreach ($categories as $category) {
            $postCategories->fill(["post" => $postId, "category" => $category]);
            $postsCategoriesModel->insert($postCategories);
          }
        }
      }
    } catch (Exception $e) {
      throw new Exception($e);
    }
  }
}
