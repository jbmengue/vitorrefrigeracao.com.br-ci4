<?php

namespace App\Libraries;

use Exception;

class Upload
{
  private $file;
  private $description = [];
  private $source = "";
  private $errors = [];
  private $success = [];
  private $sizes = [
    "small" => 300,
    "thumb" => 800,
    "medium" => 1200,
    "large" => 1920,
  ];

  public function __set($attr, $val)
  {
    if ($attr == "description" || $attr == "source") {
      $this->$attr = $val;
    }
  }

  public function __get($attr)
  {
    return $this->$attr;
  }

  public function getTotalErrors()
  {
    return count($this->errors);
  }

  public function getTotalSuccess()
  {
    return count($this->success);
  }

  public function __construct()
  {
    return $this;
  }

  private function filter($files)
  {
    if (!empty($files)) {
      foreach ($files as $file) {
        if (is_array($file)) {
          return $file;
        } else {
          return $files;
        }
      }
    } else {
      throw new Exception("Upload error [data not found] [C20]");
    }
  }

  private function hasTypeImage(): bool
  {
    $mimeType = explode("/", $this->file->getClientMimeType());
    if ($mimeType && isset($mimeType[0])) {
      if ($mimeType[0] == "image") {
        return true;
      } else {
        return false;
      }
    }
    return false;
  }

  public function initialize($files)
  {
    $_files = $this->filter($files);
    $index = 0;
    foreach ($_files as $item => $file) {
      if ($file->isValid()) {
        $this->file = $file;

        if ($this->hasTypeImage()) {
          $this->moveToWritable()->resizeImage();
        } else {
          if ($this->source === "results") {
            $this->moveResults();
          } elseif ($this->source === "attachments") {
            $this->moveAttachments();
          } else {
            $this->moveDocuments();
          }
        }
        $this->save($item, $index);
      } else {
        $this->errors[] = [
          "index" => $index,
          "message" => $file->getErrorString(),
          "file_name" => $file->getClientName(),
        ];
      }
      $index++;
    }
  }

  private function moveToWritable()
  {
    $this->file->move(WRITEPATH . "uploads", $this->file->getRandomName());
    return $this;
  }

  private function resizeImage(): void
  {
    foreach ($this->sizes as $dir => $size) {
      \Config\Services::image()
        ->withFile(WRITEPATH . "uploads/" . $this->file->getName())
        ->resize($size, $size, true, "width")
        ->save(FCPATH . "uploads/images/" . $dir . "/" . $this->file->getName());
    }
  }

  private function moveDocuments()
  {
    $this->file->move(FCPATH . "uploads/documents/", $this->file->getRandomName());
    return $this;
  }

  private function moveResults()
  {
    $this->file->move(FCPATH . "results/", $this->file->getRandomName());
    return $this;
  }

  private function moveAttachments()
  {
    $this->file->move(FCPATH . "attachments/", $this->file->getRandomName());
    return $this;
  }

  private function save($item, $index)
  {
    $description = isset($this->description[$item]) ? $this->description[$item] : "";

    $fileModel = new \App\Models\FileModel();
    $data = [
      "source" => $this->source,
      "description" => $description,
      "name" => $this->file->getName(),
      "client_mime_type" => $this->file->getClientMimeType(),
      "extension" => $this->file->getClientExtension(),
      "weight" => $this->file->getSizeByUnit("kb"),
    ];
    if (!($fileId = $fileModel->insert($data))) {
      $this->errors[] = [
        "index" => $index,
        "message" => "Erro ao tentar gravar o arquivo",
        "file_name" => $this->file->getClientName(),
      ];
    } else {
      $this->success[] = [
        "index" => $index,
        "id" => $fileId,
        "file_name" => $this->file->getName(),
      ];
    }
  }
}
