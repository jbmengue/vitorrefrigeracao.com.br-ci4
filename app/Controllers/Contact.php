<?php

namespace App\Controllers;

class Contact extends BaseController
{
  public $data = [
    "page" => "contact",
  ];

  public function __construct() {}

  public function index()
  {
    return view("layout/content", $this->data);
  }
}
