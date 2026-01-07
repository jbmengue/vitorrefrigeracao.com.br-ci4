<?php
namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Category extends Entity
{
  protected $casts = [
    "id" => "integer",
    "type" => "integer",
    "parent" => "integer",
    "order" => "integer",
    "active" => "boolean",
  ];

  protected $dates = ["created_at", "updated_at", "deleted_at"];
}
