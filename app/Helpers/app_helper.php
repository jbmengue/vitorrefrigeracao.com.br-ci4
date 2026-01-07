<?php
function jsonToArray($fileSrc)
{
  $json = file_get_contents(FCPATH . "assets/json/" . $fileSrc . ".json");
  if ($json) {
    return json_decode($json);
  }

  return null;
}

function delTree($dir)
{
  $files = array_diff(scandir($dir), [".", ".."]);
  foreach ($files as $file) {
    is_dir("$dir/$file") ? delTree("$dir/$file") : unlink("$dir/$file");
  }
  return rmdir($dir);
}
?>
