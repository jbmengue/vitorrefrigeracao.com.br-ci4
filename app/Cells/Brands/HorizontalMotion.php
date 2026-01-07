<?php

namespace App\Cells\Brands;

use CodeIgniter\View\Cells\Cell;

class HorizontalMotion extends Cell
{
  public $motionGroupNumber = 3;
  public $motionDurationInSeconds = 20;
  public array $brands = [];
  protected string $view = 'views/horizontal-motion';

  public function mount()
  {
    $technicalServicesModel = new \App\Models\TechnicalServicesModel();
    $this->brands = $technicalServicesModel->onlyActive()->getBrands();
  }
}
