<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?= isset($metaTitle) ? $metaTitle : $appConfig->title ?></title>
<meta name="theme-color" content="#000000" />
<meta name="robots" content="index,follow">
<meta name="description" content="<?= isset($metaDescription)
  ? $metaDescription
  : $appConfig->description ?>">
<meta name="copyright" content="&copy; <?= $appConfig->name .
  " " .
  date("Y") ?> - Todos os direiros reservados">
<meta name="distribution" content="Global">
<meta name="city" content="Porto alegre">
<meta name="country" content="brasil">
<link rel="shortcut icon" href="<?= base_url("favicon.ico") ?>">

<meta property="og:type" content="website">
<meta property="og:locale" content="pt_BR">
<meta property="og:url" content="<?= base_url() ?>">
<meta property="og:title" content="<?= isset($metaTitle)
  ? $metaTitle
  : $appConfig->name ?>">
<meta property="og:site_name" content="<?= $appConfig->name ?>">
<meta property="og:description" content="<?= isset($metaDescription) ? $metaDescription : "" ?>">
<meta property="og:image" content="">
<meta property="og:image:type" content="image/jpeg">
<meta property="og:image:width" content="800">
<meta property="og:image:height" content="483">

<?php
layout_snippet(['typography', 'scripts-head']);
