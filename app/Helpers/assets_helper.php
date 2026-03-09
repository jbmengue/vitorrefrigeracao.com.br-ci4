<?php
if (!function_exists("assets")) {
  function assets(string $type = "", $uri = "", ?string $protocol = null): string
  {
    if (is_array($uri)) {
      $uri = implode("/", $uri);
    }
    $uri = trim($uri, "/");
    $config = appConfig();
    $base =
      !empty($config->{$type}) && $config->{$type} !== "/"
        ? rtrim($config->{$type}, "/ ") . "/"
        : $config->{$type};

    $url = new \CodeIgniter\HTTP\URI($base);
    unset($config);

    if (!empty($uri)) {
      $url = $url->resolveRelativeURI($uri);
    }

    if (empty($protocol) && \Config\Services::request()->isSecure()) {
      $protocol = "https";
    }

    if (!empty($protocol)) {
      $url->withScheme($protocol);
    }

    $version = "";
    if ($type == "css" || $type == "js") {
      $version = "?v=" . assets_version($type, $uri);
    }

    return rtrim((string) $url, "/ ") . $version;
  }
}

if (!function_exists("assets_version")) {
  function assets_version($type, $uri): string
  {
    return filemtime(FCPATH . "assets/" . $type . "/" . $uri);
  }
}
