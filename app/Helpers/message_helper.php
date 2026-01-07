<?php
if (!function_exists("errors")) {
  function errors(array $erros = []): string
  {
    $_error = "";
    foreach ($erros as $e) {
      $_error .= "- " . $e . "\n";
    }

    return $_error;
  }
}
