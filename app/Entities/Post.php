<?php
namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Post extends Entity
{
  protected $casts = [
    "id" => "integer",
    "user" => "integer",
    "file" => "integer",
    "content" => "html-entity-decode",
    "categories" => "json-array",
    "order" => "integer",
    "featured" => "boolean",
    "active" => "boolean",
  ];

  protected $datamap = [
    "imageName" => "image_name",
    "createdAt" => "created_at",
    "updatedAt" => "updated_at",
    "deletedAt" => "deleted_at",
  ];

  protected $dates = ["date", "event_date", "created_at", "updated_at", "deleted_at"];

  protected $castHandlers = [
    "html-entity-decode" => \App\Entities\Cast\HtmlEntityDecode::class,
  ];
}
