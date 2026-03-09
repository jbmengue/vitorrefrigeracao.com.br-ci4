<?php
use App\ValueObjects\Navigation\NavItem;

/** @var \Config\Navigation $navbarConfig */
$navigationConfig = config('Navigation');

/** @var \App\ValueObjects\Navigation\NavItem[] $items */
$items        = $navigationConfig->items;

$useShortLabel = $useShortLabel ?? false;
$navItemClass = $navItemClass ?? '';
$navLinkClass = $navLinkClass ?? '';
$submenuClass = $submenuClass ?? '';
$submenuNavLinkClass = $submenuNavLinkClass ?? '';
$only = $only ?? null;
$except = $except ?? null;
$order = $order ?? null;

$isExternalUrl = static function (?string $route): bool {
    if ($route === null) {
        return false;
    }

    return str_starts_with($route, 'http://') || str_starts_with($route, 'https://');
};

$buildHref = static function (?string $route) use ($isExternalUrl): string {
    if ($route === null || $route === '') {
        return '#';
    }

    return $isExternalUrl($route) ? $route : site_url($route);
};


if (is_array($except) && ! empty($except)) {
    $items = array_filter(
        $items,
        static fn (NavItem $item): bool => ! in_array($item->key, $except, true)
    );
}

if (is_array($only) && ! empty($only)) {
    $items = array_filter(
        $items,
        static fn (NavItem $item): bool => in_array($item->key, $only, true)
    );
}

if (is_array($order) && !empty($order)) {
    $positionMap = [];
    foreach ($order as $index => $key) {
        $positionMap[$key] = $index;
    }

    usort(
        $items,
        static function (NavItem $a, NavItem $b) use ($positionMap): int {
            $aPos = $positionMap[$a->key] ?? PHP_INT_MAX;
            $bPos = $positionMap[$b->key] ?? PHP_INT_MAX;

            if ($aPos === $bPos) {
                return 0;
            }

            return $aPos <=> $bPos;
        }
    );
}


foreach ($items as $item):
    $hasChildren = $item->hasChildren();
    $isActive    = false;

    $pattern = $item->getActivePattern();
    if ($pattern !== null && url_is($pattern)) {
        $isActive = true;
    }

    if (!$isActive && $hasChildren) {
        foreach ($item->children as $child) {
            $childPattern = $child->getActivePattern();

            if ($childPattern !== null && url_is($childPattern)) {
                $isActive = true;
                break;
            }
        }
    }
    ?>
    <li class="nav-item <?= esc($navItemClass, 'attr') ?> <?= $hasChildren ? 'has-children' : '' ?> <?= $isActive ? 'is-active' : '' ?>">
        <?php if ($item->route !== null): ?>
            <a href="<?= esc($buildHref($item->route), 'attr') ?>" class="nav-link <?= esc($navLinkClass, 'attr') ?>">
                <?= esc($item->getLabel($useShortLabel)) ?>
            </a>
        <?php else: ?>
            <span class="nav-label">
                <?= esc($item->getLabel($useShortLabel)) ?>
            </span>
        <?php endif; ?>

        <?php if ($hasChildren): ?>
            <ul class="nav-submenu <?= esc($submenuClass, 'attr') ?>">
                <?php foreach ($item->children as $child): ?>
                    <?php
                    $childIsActive  = false;
                    $childPattern   = $child->getActivePattern();

                    if ($childPattern !== null && url_is($childPattern)) {
                        $childIsActive = true;
                    }
                    ?>
                    <li class="nav-subitem <?= $childIsActive ? 'is-active' : '' ?>">
                        <a href="<?= esc($buildHref($child->route), 'attr') ?>" class="nav-sublink hover:underline hover:underline-offset-4 <?= esc($submenuNavLinkClass, 'attr') ?>">
                            <?= esc($child->getLabel($useShortLabel)) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </li>
<?php endforeach; ?>
