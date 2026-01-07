<?php
namespace App\Entities;

use CodeIgniter\Entity\Entity;

class User extends Entity
{
  protected $attributes = [
    "id" => null,
    "username" => null,
    "email" => null,
    "password" => null,
    "token" => null,
    "role" => null,
    "active" => null,
    "profile" => null,
  ];

  protected $casts = [
    "id" => "integer",
    "profile_id" => "integer",
    "profile_photo" => "integer",
    "role" => "integer",
  ];

  protected $dates = ["created_at", "updated_at", "deleted_at"];
}
