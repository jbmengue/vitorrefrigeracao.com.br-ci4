<?php
$rawColor = trim((string) ($post->color ?? ''));
$serviceColor = preg_match('/^[A-Fa-f0-9]{6}$|^[A-Fa-f0-9]{3}$/', $rawColor)
  ? "#{$rawColor}"
  : '#111827';
?>
<div style="--service-color: <?= esc($serviceColor, 'attr') ?>;">
<?php
sections('service', [
  'banner',
  'same-day-service',
  'products',
  'works',
  'request-you-service'
]);
?>
</div>
