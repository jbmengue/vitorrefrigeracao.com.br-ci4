<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class CategoryModel extends Model
{
  protected $table = "categories";
  protected $primaryKey = "id";

  protected $useAutoIncrement = true;

  protected $useSoftDeletes = true;

  protected $allowedFields = ["type", "name", "description", "parent", "order", "active"];
  protected $returnType = \App\Entities\Category::class;

  protected $useTimestamps = true;
  protected $createdField = "created_at";
  protected $updatedField = "updated_at";
  protected $deletedField = "deleted_at";

  protected $validationRules = [];

  public function findByType($type = "")
  {
    return $this->select()
      ->where([$this->table . ".type" => $type])
      ->orderBy($this->table . ".order ASC, " . $this->table . ".description ASC")
      ->findAll();
  }

  public function reorder($id, $key)
  {
    return $this->set(["order" => $key])
      ->where(["id" => $id])
      ->update();
  }

  public function del($id)
  {
    try {
      $this->delete(["parent" => $id]);
      return $this->delete($id);
    } catch (Exception $e) {
      throw new Exception($e);
    }
  }
}
