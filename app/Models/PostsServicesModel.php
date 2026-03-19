<?php

namespace App\Models;

use App\Entities\PostsServices;
use App\Traits\FilterableModelTrait;
use CodeIgniter\Model;

final class PostsServicesModel extends Model
{
  use FilterableModelTrait;

  protected $table            = 'posts_services';
  protected $primaryKey       = 'post';
  protected $useAutoIncrement = false;

  protected $useSoftDeletes = true;
  protected $useTimestamps  = true;

  protected $returnType = PostsServices::class;

  protected $createdField = 'created_at';
  protected $updatedField = 'updated_at';
  protected $deletedField = 'deleted_at';

  protected $allowedFields = [
    'post',
    'group',
    'phrase',
    'file',
  ];

  public function bySlug(string $slug): self
  {
    return $this->addFilter('p.slug', $slug);
  }

  public function byType(string $type): self
  {
    return $this->addFilter('p.type', $type);
  }

  public function byServiceGroup(string $group): self
  {
    return $this->addFilter('ps.group', $group);
  }

  public function onlyActive(): self
  {
    return $this->addFilter('p.active', true);
  }

  public function findBySlug(string $slug, string $group): ?PostsServices
  {
    $this->bySlug($slug)
      ->byServiceGroup($group)
      ->byType('service')
      ->onlyActive();

    return $this->withQuery(function (self $model) {
      return $model
        ->select($this->selectWithRelations(), false)
        ->first();
    });
  }

  private function withQuery(callable $callback): mixed
  {
    try {
      $this->applyFilters();
      $this->applyRelations();

      return $callback($this);
    } finally {
      $this->resetFilters();
    }
  }

  private function applyRelations(): self
  {
    return $this
      ->from("{$this->table} ps")
      ->join('posts p', 'p.id = ps.post', 'inner')
      ->join('files post_image', 'post_image.id = p.image', 'left')
      ->join('files logo_file', 'logo_file.id = ps.file', 'left')
      ->where('p.deleted_at IS NULL', null, false)
      ->where('ps.deleted_at IS NULL', null, false);
  }

  private function selectWithRelations(): string
  {
    return "
      ps.post,
      ps.`group` AS service_group,
      ps.phrase,
      ps.color,
      ps.file AS logo,
      logo_file.name AS logo_name,
      p.id AS post_id,
      p.slug,
      p.type,
      p.title,
      p.subtitle,
      p.content,
      p.reference,
      p.image,
      post_image.name AS image_name,
      p.active,
      (
        SELECT COALESCE(
          CONCAT(
            '[',
            GROUP_CONCAT(
              JSON_OBJECT(
                'id', sp.id,
                'icon', sp.icon,
                'label', sp.label,
                'order', sp.`order`
              )
              ORDER BY sp.`order` ASC, sp.id ASC
              SEPARATOR ','
            ),
            ']'
          ),
          JSON_ARRAY()
        )
        FROM posts_services_products psp
        INNER JOIN service_products sp ON sp.id = psp.product
        WHERE psp.post = ps.post
          AND sp.deleted_at IS NULL
          AND sp.active = 1
      ) AS products,
      (
        SELECT COALESCE(
          JSON_ARRAYAGG(
            JSON_OBJECT(
              'id', ordered_works.id,
              'title', ordered_works.title,
              'description', ordered_works.description,
              'order', ordered_works.sort_order,
              'file', ordered_works.file,
              'fileName', ordered_works.file_name
            )
          ),
          JSON_ARRAY()
        )
        FROM (
          SELECT
            sw.post AS post_id,
            sw.id,
            sw.title,
            sw.description,
            sw.`order` AS sort_order,
            sw.file,
            work_file.name AS file_name
          FROM service_works sw
          LEFT JOIN files work_file ON work_file.id = sw.file
          WHERE sw.deleted_at IS NULL
            AND sw.active = 1
          ORDER BY sw.`order` ASC, sw.id ASC
        ) AS ordered_works
        WHERE ordered_works.post_id = ps.post
      ) AS works
    ";
  }
}
