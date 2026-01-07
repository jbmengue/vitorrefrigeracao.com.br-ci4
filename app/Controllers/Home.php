<?php

namespace App\Controllers;

class Home extends BaseController
{
  
  public function __construct() {
    $this->data['page'] = 'home';
  }

  public function index()
  {
    return $this->render();
  }
}
