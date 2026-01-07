<?php
namespace App\API\Admin;

use App\API\BaseAPIController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class File extends BaseAPIController
{
  use ResponseTrait;

  public function __construct()
  {
    helper("message");
  }

  public function index() {}

  public function create()
  {
    $validated = $this->validate([
      "Foto" => [
        "uploaded[file]",
        "mime_in[file,image/jpg,image/jpeg,image/png,application/pdf,text/html]",
        "max_size[file,2000]",
      ],
    ]);
    if ($validated) {
      $upload = new \App\Libraries\Upload();
      $upload->source = $this->request->getPostGet("fileSource");
      $upload->initialize($this->request->getFiles("file"));

      if ($upload->getTotalErrors() > 0) {
        return $this->getResponse(
          ["return" => "warning", "message" => errors($upload->errors)],
          ResponseInterface::HTTP_OK,
        );
      }

      return $this->getResponse(
        [
          "return" => "success",
          "message" => "Atualizada com sucesso!",
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
