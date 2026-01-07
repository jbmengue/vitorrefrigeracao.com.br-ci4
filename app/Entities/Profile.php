<?php
namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Profile extends Entity
{
  protected $attributes = [
    "id" => null,
    "name" => null,
    "file" => null,
    "document" => null,
    "phone_ddd" => null,
    "phone" => null,
    "address" => null,
    "address_zipcode" => null,
    "address_number" => null,
    "address_complementary" => null,
    "address_city" => null,
    "address_neighborhood" => null,
  ];

  protected $casts = [
    "id" => "integer",
    "file" => "integer",
  ];

  protected $dates = ["created_at", "updated_at"];

  public function __get($key)
  {
    if (property_exists($this, $key)) {
      return $this->$key;
    }
  }

  public function __set($key, $value)
  {
    if (property_exists($this, $key)) {
      $this->$key = $value;
    }
  }
}
