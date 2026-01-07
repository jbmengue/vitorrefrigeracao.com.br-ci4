<?php

namespace App\Models;

use App\Traits\FilterableModelTrait;
use CodeIgniter\Model;

class TechnicalServicesModel extends Model
{
  use FilterableModelTrait;
  protected $table      = 'technical_services';
  protected $primaryKey = 'id';

  protected $useAutoIncrement = true;
  protected $useSoftDeletes = true;
  protected $useTimestamps = true;

  protected $allowedFields = [
    'name',
    'title',
    'relationship',
    'active',
    '`order`',
  ];
  protected $returnType = \App\Entities\TechnicalServices::class;

  protected $createdField = "created_at";
  protected $updatedField = "updated_at";
  protected $deletedField = "deleted_at";

  private array $filters = [];

  public function onlyActive(): self
  {
    return $this->addFilter('active', true);
  }

  public function byRelationship(string $relationship): self
  {
    return $this->addFilter('relationship', $relationship);
  }

  public function byShowInMenu(string $key): self {
    return $this->addFilter('show_in_menu', $key);
  }

  public function getBrands(): array
  {
    $this->addFilter('type', 'brand');
    return $this->getTechnicalServices();
  }

  public function getServices(): array
  {
    $this->addFilter('type', 'services');
    return $this->getTechnicalServices();
  }

  public function getTechnicalServices(): array
  {
    return $this->withFilters(function (self $model) {
      return $model
        ->select([
            "{$this->table}.*",
            "files.name AS file_name",
        ])
        ->join('files', 'files.id = ' . $this->table . '.file', 'LEFT')
        ->orderBy('`order`', 'ASC', false)
        ->orderBy('title', 'ASC')
        ->findAll();
    });
  }
}
