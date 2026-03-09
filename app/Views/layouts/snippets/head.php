<?php
$title = isset($metaTitle) && $metaTitle !== ''
  ? $metaTitle
  : ($appConfig->title !== '' ? $appConfig->title : $appConfig->name);

$description = isset($metaDescription) && $metaDescription !== ''
  ? $metaDescription
  : $appConfig->description;

$canonicalUrl = current_url();

$ogImage = isset($metaImage) && $metaImage !== '' ? $metaImage : null;
$ogImageType = isset($metaImageType) && $metaImageType !== '' ? $metaImageType : 'image/jpeg';
$ogImageWidth = $metaImageWidth ?? $metaImageWidht ?? null;
$ogImageHeight = $metaImageHeight ?? null;
?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?= esc($title) ?></title>
<meta name="theme-color" content="#000000" />
<meta name="robots" content="index,follow">
<meta name="description" content="<?= esc($description) ?>">
<meta name="copyright" content="&copy; <?= esc($appConfig->name . ' ' . date('Y')) ?> - Todos os direiros reservados">
<meta name="distribution" content="Global">
<meta name="city" content="Porto alegre">
<meta name="country" content="brasil">
<link rel="shortcut icon" href="<?= base_url('favicon.ico') ?>">
<link rel="canonical" href="<?= esc($canonicalUrl) ?>">

<meta property="og:type" content="website">
<meta property="og:locale" content="pt_BR">
<meta property="og:url" content="<?= esc($canonicalUrl) ?>">
<meta property="og:title" content="<?= esc($title) ?>">
<meta property="og:site_name" content="<?= esc($appConfig->name) ?>">
<meta property="og:description" content="<?= esc($description) ?>">

<?php 
if ($ogImage !== null): ?>
  <meta property="og:image" content="<?= esc($ogImage) ?>">
  <meta property="og:image:type" content="<?= esc($ogImageType) ?>">
  
  <?php 
  if ($ogImageWidth !== null): ?>
    <meta property="og:image:width" content="<?= esc((string) $ogImageWidth) ?>">
  <?php endif; ?>
  
  <?php 
  if ($ogImageHeight !== null): ?>
    <meta property="og:image:height" content="<?= esc((string) $ogImageHeight) ?>">
  <?php endif; ?>
<?php endif; ?>

<?php
layout_snippet(['typography', 'scripts-head', 'scripts-tracking']);
