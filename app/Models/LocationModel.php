<?php

namespace App\Models;

use App\Traits\FilterableModelTrait;
use CodeIgniter\Model;

class LocationModel extends Model
{
  use FilterableModelTrait;
  protected $table      = 'locations';
  protected $primaryKey = 'id';

  protected $useAutoIncrement = true;
  protected $useSoftDeletes = true;
  protected $useTimestamps = true;

  protected $allowedFields = [
    'title',
    'active',
    '`order`',
  ];
  protected $returnType = \App\Entities\Location::class;

  protected $createdField = "created_at";
  protected $updatedField = "updated_at";
  protected $deletedField = "deleted_at";

  private array $filters = [];

  public function onlyActive(): self
  {
    return $this->addFilter('active', true);
  }

  public function getLocations(): array
  {
    return $this->withFilters(function (self $model) {
      return $model
        ->orderBy('`order`', 'ASC', false)
        ->orderBy('title', 'ASC')
        ->findAll();
    });
  }
}
