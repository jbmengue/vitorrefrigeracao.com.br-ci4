<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class StatusModel extends Model
{
  protected $table = "status";
  protected $primaryKey = "id";

  protected $useAutoIncrement = true;

  protected $useSoftDeletes = true;

  protected $allowedFields = [];
  protected $returnType = \App\Entities\Status::class;

  protected $useTimestamps = true;
  protected $createdField = "created_at";
  protected $updatedField = "updated_at";
  protected $deletedField = "deleted_at";

  protected $validationRules = [];

  public function findByDepartament(string $departament = "")
  {
    return $this->where(["departament" => $departament])->findAll();
  }

  public function findByCode($code = 0)
  {
    return $this->where(["code" => $code])->first();
  }
}
