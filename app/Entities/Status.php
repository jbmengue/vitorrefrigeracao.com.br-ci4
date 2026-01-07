<?php
namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Status extends Entity
{
  protected $attributes = [
    "id" => null,
    "name" => null,
    "description" => null,
    "text" => null,
    "method" => null,
    "departament" => null,
    "code" => null,
    "color" => null,
    "action" => null,
  ];

  protected $casts = [
    "id" => "integer",
    "code" => "integer",
  ];

  protected $dates = ["created_at", "updated_at", "deleted_at"];
}
