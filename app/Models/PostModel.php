<?php

namespace App\Models;

use App\Entities\Post;
use App\Traits\FilterableModelTrait;
use CodeIgniter\Model;

final class PostModel extends Model
{
  use FilterableModelTrait;

  protected $table            = 'posts';
  protected $primaryKey       = 'id';
  protected $useAutoIncrement = true;

  protected $useSoftDeletes = true;
  protected $useTimestamps  = true;

  protected $returnType = Post::class;

  protected $createdField = 'created_at';
  protected $updatedField = 'updated_at';
  protected $deletedField = 'deleted_at';

  protected $allowedFields = [
    'user',
    'image',
    'type',
    'date',
    'slug',
    'title',
    'subtitle',
    'content',
    'tags',
    'reference',
    'order',
    'featured',
    'active',
  ];

  protected $validationRules = [];

  private int $limit  = 0;
  private int $offset = 0;

  public function limit(int $limit): self
  {
    $this->limit = max(0, $limit);
    return $this;
  }

  public function offset(int $offset): self
  {
    $this->offset = max(0, $offset);
    return $this;
  }

  public function onlyActive(): self
  {
    return $this->addFilter($this->table . '.active', true);
  }

  public function byType(string $type): self
  {
    return $this->addFilter($this->table . '.type', $type);
  }

  public function bySlug(string $slug): self
  {
    return $this->addFilter($this->table . '.slug', $slug);
  }

  public function exceptId(int $id): self
  {
    return $this->addFilter($this->table . '.id <>', $id);
  }

  public function findByType(string $type): array
  {
    $this->byType($type);

    $orderByMap = [
      'news' => "{$this->table}.date DESC, {$this->table}.created_at DESC, {$this->table}.id ASC",
    ];

    $orderBy = $orderByMap[$type] ?? "{$this->table}.created_at DESC, {$this->table}.id DESC";

    return $this->withQuery(function (self $model) use ($orderBy) {
      return $model
        ->select($this->selectWithRelations(), false)
        ->orderBy($orderBy, '', false)
        ->groupBy($this->table . '.id')
        ->findAll($this->limit, $this->offset);
    });
  }

  public function findBySlug(string $type, string $slug): ?Post
  {
    $this->byType($type)->bySlug($slug);

    return $this->withQuery(function (self $model) {
      return $model
        ->select($this->selectWithRelations(), false)
        ->orderBy($this->table . '.id', 'DESC')
        ->groupBy($this->table . '.id')
        ->first();
    });
  }

  public function findRelated(string $type, int $postId): array
  {
    $this->byType($type)->exceptId($postId);

    return $this->withQuery(function (self $model) {
      return $model
        ->select($this->selectWithRelations(), false)
        ->orderBy("{$this->table}.created_at", 'DESC')
        ->orderBy("{$this->table}.id", 'ASC')
        ->groupBy($this->table . '.id')
        ->findAll($this->limit);
    });
  }

  public function reorder(int $id, int $order): bool
  {
    return (bool) $this->set(['order' => $order])
      ->where(['id' => $id])
      ->update();
  }

  private function withQuery(callable $callback): mixed
  {
    try {
      $this->applyFilters();
      $this->applyRelations();

      return $callback($this);
    } finally {
      $this->resetFilters();
      $this->resetQueryParams();
    }
  }

  private function resetQueryParams(): void
  {
    $this->limit  = 0;
    $this->offset = 0;
  }

  private function applyRelations(): self
  {
    return $this
      ->join('files', "files.id = {$this->table}.image", 'left')
      ->join('posts_categories', "posts_categories.post = {$this->table}.id", 'left')
      ->join('categories', 'posts_categories.category = categories.id', 'left');
  }

  private function selectWithRelations(): string
  {
    return "
        {$this->table}.*,
        JSON_ARRAYAGG(
            JSON_OBJECT(
                'id', posts_categories.category,
                'name', categories.name,
                'description', categories.description
            )
        ) as categories,
        files.id as image,
        files.name as image_name
    ";
  }
}
