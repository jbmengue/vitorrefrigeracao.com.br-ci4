<?php

namespace App\Cells\Location;

use CodeIgniter\View\Cells\Cell;

class Footer extends Cell
{
  public array $locations = [];
  protected string $view = 'views/footer';

  public function mount()
  {
    $locationModel = new \App\Models\LocationModel();
    $this->locations = $locationModel->onlyActive()->getLocations();
  }
}
