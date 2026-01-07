<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class ProfileModel extends Model
{
  protected $table = "profiles";
  protected $primaryKey = "id";

  protected $useAutoIncrement = true;

  protected $useSoftDeletes = false;

  protected $allowedFields = [
    "name",
    "file",
    "document",
    "phone_ddd",
    "phone",
    "address",
    "address_zipcode",
    "address_number",
    "address_complementary",
    "address_city",
    "address_state",
    "address_neighborhood",
  ];
  protected $returnType = \App\Entities\Profile::class;

  protected $useTimestamps = true;
  protected $createdField = "created_at";
  protected $updatedField = "updated_at";
  protected $deletedField = "deleted_at";

  protected $validationRules = [
    "name" => "required|min_length[3]",
    "file" => "required|is_natural",
  ];

  protected $skipValidation = false;
}
