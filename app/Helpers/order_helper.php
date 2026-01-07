<?php
function getTotalOrder($items): array
{
  if ($items) {
    $totalPrice = 0;
    $totalItems = 0;
    foreach ($items as $item) {
      $totalItems++;
      if (null != $item->price_promotional) {
        $totalPrice += $item->price_promotional;
      } else {
        $totalPrice += $item->price;
      }
    }
    return ["total" => $totalPrice, "items" => $totalItems];
  }

  return ["total" => 0, "items" => 0];
}
?>
