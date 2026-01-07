<?php
declare(strict_types=1);

namespace App\ValueObjects\Navigation;

final class NavItem
{
    public function __construct(
        public readonly string $key,
        public readonly string $label,
        public readonly ?string $route = null,
        public readonly ?string $activePattern = null,
        public readonly array $children = [],
        public readonly ?string $shortLabel = null,
    ) {
    }

    public function hasChildren(): bool
    {
        return $this->children !== [];
    }

    public function getActivePattern(): ?string
    {
        if ($this->activePattern !== null) {
            return $this->activePattern;
        }

        if ($this->route === null) {
            return null;
        }

        $trimmed = trim($this->route, '/');

        if ($trimmed === '') {
            return '/';
        }

        return $trimmed . '*';
    }

    public function getLabel(bool $useShort = false): string
    {
        if ($useShort && $this->shortLabel !== null) {
            return $this->shortLabel;
        }

        return $this->label;
    }
}
