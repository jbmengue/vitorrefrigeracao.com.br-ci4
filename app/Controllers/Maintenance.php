<?php

namespace App\Controllers;

class Maintenance extends BaseController
{
  public $data = [
    "page" => "maintenance",
  ];

  public function __construct() {}

  public function index()
  {
    return view("layout/content", $this->data);
  }
}
