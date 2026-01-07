<?php

namespace App\Traits;

trait FilterableModelTrait
{
  private array $filters = [];

  protected function addFilter(string $field, mixed $value): self
  {
    if ($field !== '' && $value !== null) {
      $this->filters[$field] = $value;
    }

    return $this;
  }

  protected function applyFilters(): self
  {
    foreach ($this->filters as $field => $value) {
      if (is_array($value)) {
        $this->whereIn($field, $value);
        continue;
      }

      $this->where($field, $value);
    }

    return $this;
  }

  protected function resetFilters(): void
  {
    $this->filters = [];
  }

  protected function withFilters(callable $callback): mixed
  {
    try {
      $this->applyFilters();
      return $callback($this);
    } finally {
      $this->resetFilters();
    }
  }
}
