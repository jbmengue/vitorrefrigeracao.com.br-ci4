<?php
namespace App\Entities;

use CodeIgniter\Entity\Entity;

class PostCategory extends Entity
{
  protected $casts = [
    "post" => "integer",
    "category" => "integer",
    "categories" => "json-array",
  ];
}
