<?php
namespace App\Entities;

use CodeIgniter\Entity\Entity;

class RecoverPassword extends Entity
{
  protected $attributes = [
    "id" => null,
    "token" => null,
    "email" => null,
    "user" => null,
  ];

  protected $casts = [
    "id" => "integer",
    "user" => "integer",
  ];

  protected $dates = ["created_at", "updated_at", "deleted_at"];
}
