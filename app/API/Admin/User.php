<?php
namespace App\API\Admin;

use App\API\BaseAPIController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class User extends BaseAPIController
{
  use ResponseTrait;

  private $userModel;
  private $profileModel;

  public function __construct()
  {
    helper("message");
    $this->userModel = new \App\Models\UserModel();
    $this->profileModel = new \App\Models\ProfileModel();
  }

  public function index()
  {
    $users = $this->userModel->findUsers();
    return $this->getResponse($users, ResponseInterface::HTTP_OK);
  }

  public function show($id = null)
  {
    $user = $this->userModel->findAllData($id);
    return $this->getResponse($user, ResponseInterface::HTTP_OK);
  }

  public function byRole($role = null)
  {
    $user = $this->userModel->findByRole($role);
    return $this->getResponse($user, ResponseInterface::HTTP_OK);
  }

  public function create()
  {
    try {
      $request = $this->request->getJSON(true);
      if ($profile = $this->profileSave($request)) {
        $request["profile"] = $profile;
        if ($this->userModel->insert($request) === false) {
          return $this->getResponse(
            ["return" => "warning", "message" => errors($this->userModel->errors())],
            ResponseInterface::HTTP_OK,
          );
        }

        return $this->getResponse(
          ["return" => "success", "message" => "Usuário cadastrado com sucesso"],
          ResponseInterface::HTTP_CREATED,
        );
      }
    } catch (Exception $e) {
      return $this->getResponse(
        ["return" => "danger", "message" => $e->getMessage()],
        ResponseInterface::HTTP_BAD_REQUEST,
      );
    }
  }

  private function profileSave(array $data)
  {
    $_data = $this->getDataForSaveProfile($data);
    if ($this->profileModel->save($_data) !== false) {
      return $this->profileModel->getInsertID();
    }

    return $this->getResponse(
      ["return" => "warning", "message" => errors($this->profileModel->errors())],
      ResponseInterface::HTTP_OK,
    );
  }

  private function getDataForSaveProfile(array $data): array
  {
    $_data["id"] = $data["profileId"];
    $_data["name"] = $data["profileName"];
    $_data["file"] = $data["profilePhoto"];
    return $_data;
  }

  private function getDataUpdate(int $id): array
  {
    $request = $this->request->getJSON(true);
    if ($request) {
      $request["id"] = $id;
      if (isset($request["password"]) && $request["password"] == "") {
        unset($request["password"]);
      }

      return $request;
    } else {
      throw new Exception("Update error [data not found] [C20]");
    }
  }

  public function update($id = null)
  {
    try {
      $data = $this->getDataUpdate($id);
      if (!isset($data["resetPassword"])) {
        $this->profileSave($data);
      }

      if ($this->userModel->update($id, $data) === false) {
        return $this->getResponse(
          ["return" => "warning", "message" => errors($this->userModel->getErrors())],
          ResponseInterface::HTTP_OK,
        );
      }

      return $this->getResponse(
        ["return" => "success", "message" => "Usuário atualizado com sucesso"],
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
      if ($this->userModel->delete($id)) {
        return $this->getResponse(
          ["return" => "success", "message" => "Usuário foi excluído com sucesso!"],
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

  public function role()
  {
    $roles = $this->userModel->findAllRoles();
    return $this->getResponse($roles, ResponseInterface::HTTP_OK);
  }

  public function photo()
  {
    $validated = $this->validate([
      "Foto" => [
        "uploaded[photo]",
        "mime_in[photo,image/jpg,image/jpeg,image/png]",
        "max_size[photo,2000]",
      ],
    ]);
    if ($validated) {
      $upload = new \App\Libraries\Upload();
      $upload->source = "profile";
      $upload->initialize($this->request->getFiles("photo"));

      if ($upload->getTotalErrors() > 0) {
        return $this->getResponse(
          ["return" => "warning", "message" => errors($upload->errors)],
          ResponseInterface::HTTP_OK,
        );
      }

      return $this->getResponse(
        [
          "return" => "success",
          "message" => "Foto atualizada com sucesso!",
          "files" => $upload->success,
        ],
        ResponseInterface::HTTP_OK,
      );
    } else {
      return $this->getResponse(
        ["return" => "danger", "message" => errors($this->validator->getErrors())],
        ResponseInterface::HTTP_BAD_REQUEST,
      );
    }
  }
}
