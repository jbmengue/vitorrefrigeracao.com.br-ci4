<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class TechnicalServices extends Entity
{
  protected $casts = [
    'id' => 'integer',
    'active' => 'boolean',
    'order' => 'integer'
  ];

  protected $datamap = [
    "fileName" => "file_name",
    "showInMenu" => "show_in_menu",
    "actionType" => "action_type",
    "actionVariant" => "action_variant",
    "actionLabel" => "action_label",
    "actionLink" => "action_link",
    "createdAt" => "created_at",
    "updatedAt" => "updated_at",
    "deletedAt" => "deleted_at",
  ];

  public function relationshipLabel(): ?string
  {
    return match ($this->attributes['relationship'] ?? '') {
      'authorized' => 'Autorizada',
      'accredited' => 'Credenciada',
      default      => null,
    };
  }

  protected $dates = ["created_at", "updated_at", "deleted_at"];
}
