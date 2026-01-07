<?php

namespace App\Models;

use CodeIgniter\Model;

class RecoverPasswordModel extends Model
{
  protected $table = "recover_password";
  protected $primaryKey = "id";

  protected $useAutoIncrement = true;

  protected $useSoftDeletes = true;

  protected $allowedFields = ["token", "email", "user"];
  protected $returnType = \App\Entities\RecoverPassword::class;

  protected $useTimestamps = true;
  protected $createdField = "created_at";
  protected $updatedField = "updated_at";
  protected $deletedField = "deleted_at";

  protected $validationRules = [
    "token" => "required",
    "email" => "required|valid_email",
    "user" => "required",
  ];

  protected $skipValidation = false;

  public function hasRecoveryPassword($token)
  {
    return $this->where("token", $token)->where("DATE(created_at) = CURDATE()")->first();
  }
}
