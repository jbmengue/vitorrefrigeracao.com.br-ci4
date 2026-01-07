<?php
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function getJWTFromRequest($authenticationHeader): string
{
  if (is_null($authenticationHeader)) {
    throw new Exception("Missing or invalid JWT in request");
  }

  return explode(" ", $authenticationHeader)[1];
}

function validateJWTFromRequest(string $encodeToken)
{
  $key = Services::getJWTSecretKey();
  $decodeToken = JWT::decode($encodeToken, new Key($key, "HS256"));
  $userModel = new \App\Models\UserModel();
  $userModel->findUserByEmail($decodeToken->email);
}

function getSignedJWTForUser(string $email)
{
  $issuedAtTime = time();
  $tokenTimeToLive = Services::getJWTTime();
  $tokenExpiration = $issuedAtTime + $tokenTimeToLive;
  $payload = [
    "email" => $email,
    "iat" => $issuedAtTime,
    "exp" => $tokenExpiration,
  ];

  $jwt = JWT::encode($payload, Services::getJWTSecretKey(), "HS256");
  return $jwt;
}
