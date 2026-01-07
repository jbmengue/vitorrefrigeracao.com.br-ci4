<?php
namespace App\Entities\Cast;

use CodeIgniter\Entity\Cast\BaseCast;

class HtmlEntityDecode extends BaseCast
{
  public static function get($value, array $params = [])
  {
    return html_entity_decode($value);
  }

  public static function set($value, array $params = [])
  {
    return htmlentities($value);
  }
}
?>
