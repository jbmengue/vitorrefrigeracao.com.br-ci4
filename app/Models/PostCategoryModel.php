<?php

namespace App\Models;

use CodeIgniter\Model;

class PostCategoryModel extends Model
{
  protected $table = "posts_categories";
  protected $primaryKey = "post";

  protected $useAutoIncrement = false;

  protected $useSoftDeletes = false;

  protected $allowedFields = ["post", "category"];
  protected $returnType = \App\Entities\PostCategory::class;

  protected $validationRules = [
    "post" => "is_natural_no_zero",
    "category" => "is_natural_no_zero",
  ];

  public function findCategoriesByPost($post = "")
  {
    return $this->select(
      '
                JSON_ARRAYAGG(category) as categories
            ',
    )
      ->where(["post" => $post])
      ->orderBy("category ASC")
      ->first();
  }
}
