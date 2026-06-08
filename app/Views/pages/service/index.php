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
  'content',
  'products',
  'works',
  'open-ticket-link',
  'request-you-service'
]);
?>
</div>
