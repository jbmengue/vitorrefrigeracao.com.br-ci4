<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class UserModel extends Model
{
  protected $table = "users";
  protected $primaryKey = "id";

  protected $useAutoIncrement = true;

  protected $useSoftDeletes = true;

  protected $allowedFields = [
    "username",
    "email",
    "password",
    "token",
    "role",
    "profile",
    "active",
  ];
  protected $returnType = \App\Entities\User::class;

  protected $useTimestamps = true;
  protected $createdField = "created_at";
  protected $updatedField = "updated_at";
  protected $deletedField = "deleted_at";

  protected $validationRules = [
    "id" => "is_natural_no_zero|permit_empty",
    "username" => "required|alpha_numeric_space|min_length[3]|is_unique[users.username,id,{id}]",
    "email" => "required|valid_email|is_unique[users.email,id,{id}]",
    "password" => "required|min_length[8]",
    "role" => "required",
    "profile" => "required",
  ];
  //protected $validationMessages = [];
  protected $skipValidation = false;
  protected $beforeInsert = ["hashPassword"];
  protected $beforeUpdate = ["hashPassword"];

  protected function hashPassword(array $data)
  {
    if (!isset($data["data"]["password"])) {
      return $data;
    }

    $data["data"]["password"] = password_hash($data["data"]["password"], PASSWORD_DEFAULT);
    return $data;
  }

  protected function insertValidate()
  {
    $this->setValidationRule("password", "required|min_length[8]");
  }

  public function userActivate($token)
  {
    $user = $this->select("id, email")
      ->where(["token" => $token])
      ->first();

    if ($user) {
      $update = $this->set(["active" => 1])
        ->where(["id" => $user->id])
        ->update();
      if ($update) {
        return $this->findUserByEmail($user->email);
      } else {
        throw new Exception("Não foi possível ativar a conta! Entre com contato conosco.");
      }
    } else {
      throw new Exception("Token não foi encontrado!");
    }
  }

  public function findUserByEmail(string $email)
  {
    $user = $this->select(
      '
                users.*,
                roles.id as role,
                roles.name as role_name,
                roles.description as role_description,
                roles.allow as role_allow,
                profiles.id as profile_id,
                profiles.name as profile_name,
                profiles.document as profile_document,
                profiles.phone as profile_phone,
                profiles.phone_ddd as profile_phone_ddd,
                profiles.address as profile_address,
                profiles.address_number as profile_address_number,
                profiles.address_complementary as profile_address_complementary,
                profiles.address_city as profile_address_city,
                profiles.address_state as profile_address_state,
                profiles.address_neighborhood as profile_address_neighborhood,
                profiles.address_zipcode as profile_address_zipcode,
                profiles.file as profile_photo,
                files.name as profile_photo_name
                ',
    )
      ->join("roles", "roles.id = users.role", "INNER JOIN", false)
      ->join("profiles", "profiles.id = users.profile", "INNER JOIN", false)
      ->join("files", "files.id = profiles.file", "INNER JOIN", false)
      ->where(["email" => $email])
      ->first();
    if (!$user) {
      throw new Exception("O usuário não existe para o endereço de e-mail informado.");
    }

    return $user;
  }

  public function findUsers()
  {
    return $this->select(
      '
                users.id,
                users.username, 
                users.email,
                users.created_at,
                users.updated_at,
                roles.id as role,
                roles.name as role_name,
                roles.allow as role_allow,
                roles.description as role_description,
                profiles.id as profile_id,
                profiles.name as profile_name,
                profiles.file as profile_photo,
                files.name as profile_photo_name',
    )
      ->join("roles", "roles.id = users.role", "INNER JOIN", false)
      ->join("profiles", "profiles.id = users.profile", "INNER JOIN", false)
      ->join("files", "files.id = profiles.file", "INNER JOIN", false)
      ->whereNotIn("username", ["root"])
      ->orderBy("created_at DESC")
      ->findAll();
  }

  public function findByRole($role, $order = "profiles.name ASC")
  {
    return $this->select(
      '
                users.id,
                users.username, 
                users.email,
                users.created_at,
                users.updated_at,
                roles.id as role,
                roles.name as role_name,
                roles.allow as role_allow,
                roles.description as role_description,
                profiles.id as profile_id,
                profiles.name as profile_name,
                profiles.file as profile_photo,
                files.name as profile_photo_name',
    )
      ->join("roles", "roles.id = users.role", "INNER JOIN", false)
      ->join("profiles", "profiles.id = users.profile", "INNER JOIN", false)
      ->join("files", "files.id = profiles.file", "INNER JOIN", false)
      ->where(["roles.name" => $role])
      ->whereNotIn("username", ["root"])
      ->orderBy($order)
      ->findAll();
  }

  public function findAllData($user)
  {
    $user = $this->select(
      '
                users.id, users.username, users.email,
                roles.name as role_name,
                roles.description as role_description,
                roles.allow as role_allow,
                profiles.name as name,
                profiles.document as document,
                profiles.address as address,
                profiles.address_zipcode as address_zipcode,
                profiles.address_number as address_number,
                profiles.address_complementary as address_complementary,
                profiles.address_city as address_city,
                profiles.address_neighborhood as address_neighborhood,
                files.name as photo
                ',
    )
      ->join("roles", "roles.id = users.role", "INNER JOIN", false)
      ->join("profiles", "profiles.id = users.profile", "INNER JOIN", false)
      ->join("files", "files.id = profiles.file", "INNER JOIN", false)
      ->where(["users.id" => $user])
      ->first();
    if (!$user) {
      throw new Exception("User does not exist.");
    }

    return $user;
  }

  public function findAllRoles(): array
  {
    if ($roles = $this->db->table("roles")->get()->getResult()) {
      return $roles;
    }

    return [];
  }
}
