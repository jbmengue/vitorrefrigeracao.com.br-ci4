<?php
namespace App\Entities;

use CodeIgniter\Entity\Entity;

class File extends Entity
{
  protected $attributes = [
    "id" => null,
    "source" => null,
    "name" => null,
    "client_mime_type" => null,
    "description" => null,
    "extension" => null,
    "weight" => null,
  ];

  protected $casts = [
    "id" => "integer",
  ];

  protected $dates = ["created_at", "updated_at", "deleted_at"];
}
