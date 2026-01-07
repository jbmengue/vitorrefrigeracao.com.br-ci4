<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Location extends Entity
{
  protected $casts = [
    'id' => 'integer',
    'active' => 'boolean',
    'order' => 'integer'
  ];

  protected $datamap = [
    'stateAbbr' => 'state_abbr',
    'stateFullName' => 'state_full_name',
    'createdAt' => 'created_at',
    'updatedAt' => 'updated_at',
    'deletedAt' => 'deleted_at',
  ];

  protected $dates = ["created_at", "updated_at", "deleted_at"];
}
