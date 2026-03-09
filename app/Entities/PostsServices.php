<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class PostsServices extends Entity
{
  protected $casts = [
    'post' => 'integer',
    'logo' => 'integer',
    'post_id' => 'integer',
    'image' => 'integer',
    'active' => 'boolean',
    'products' => 'json',
    'works' => 'json',
  ];

  protected $datamap = [
    'serviceGroup' => 'service_group',
    'postId' => 'post_id',
    'imageName' => 'image_name',
    'logoName' => 'logo_name',
    'createdAt' => 'created_at',
    'updatedAt' => 'updated_at',
    'deletedAt' => 'deleted_at',
  ];

  protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
