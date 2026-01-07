<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class FileModel extends Model
{
  protected $table = "files";
  protected $primaryKey = "id";

  protected $useAutoIncrement = true;

  protected $useSoftDeletes = true;

  protected $allowedFields = [
    "source",
    "name",
    "client_mime_type",
    "description",
    "extension",
    "weight",
  ];
  protected $returnType = \App\Entities\File::class;

  protected $useTimestamps = true;
  protected $createdField = "created_at";
  protected $updatedField = "updated_at";
  protected $deletedField = "deleted_at";

  protected $validationRules = [
    "name" => "required|min_length[3]",
    "client_mime_type" => "required|min_length[3]",
    "extension" => "required|min_length[3]",
    "weight" => "required|min_length[3]",
  ];
  //protected $validationMessages = [];
  protected $skipValidation = false;
}
