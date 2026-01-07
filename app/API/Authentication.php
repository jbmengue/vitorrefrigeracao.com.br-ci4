<?php
namespace App\API;

use App\API\BaseAPIController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class Authentication extends BaseAPIController
{
  use ResponseTrait;

  private $userModel;
  private $profileModel;
  private $session = null;
  private $dataSave = [];

  public function __construct()
  {
    helper(["message", "text"]);
    $this->profileModel = new \App\Models\ProfileModel();
    $this->userModel = new \App\Models\UserModel();
  }

  public function index()
  {
    $rules = [
      "email" => "required|min_length[6]|max_length[50]|valid_email",
      "password" => "required|min_length[6]|max_length[255]|validateUser[email, password]",
    ];
    $errors = [
      "password" => [
        "validateUser" => "Invalid login credentials provided",
      ],
    ];

    $input = $this->getRequestInput($this->request);

    if (!$this->validateRequest($input, $rules, $errors)) {
      return $this->getResponse(
        $this->validator->getErrors(),
        ResponseInterface::HTTP_UNAUTHORIZED,
      );
    }

    $this->setSession($input);
    return $this->getJWTForUser($input["email"]);
  }

  private function setSession($input): void
  {
    if (isset($input["session"]) && $input["session"] !== null) {
      $this->session = $input["session"];
    }
  }

  private function getJWTForUser(string $email, int $responseCode = ResponseInterface::HTTP_OK)
  {
    try {
      $user = $this->userModel->findUserByEmail($email);
      $this->setUserOrder($user->id);
      unset($user->password);

      helper("jwt");

      return $this->getResponse([
        "access" => "allowed",
        "message" => "User authenticated successfully",
        "user" => [
          "id" => $user->id,
          "email" => $user->email,
          "username" => $user->username,
          "name" => $user->profile_name,
          "document" => $user->profile_document,
          "phone_ddd" => $user->profile_phone_ddd,
          "phone" => $user->profile_phone,
          "address" => [
            "street" => $user->profile_address,
            "number" => $user->profile_address_number,
            "zipcode" => $user->profile_address_zipcode,
            "complementary" => $user->profile_address_complementary,
            "city" => $user->profile_address_city,
            "state" => $user->profile_address_state,
            "neighborhood" => $user->profile_address_neighborhood,
          ],
          "role" => $user->role,
          "role_name" => $user->role_name,
          "role_description" => $user->role_description,
          "role_allow" => $user->role_allow,
          "profile_photo" => $user->profile_photo,
          "profile_photo_name" => $user->profile_photo_name,
          "profile_name" => $user->profile_name,
          "profile_id" => $user->profile_id,
        ],
        "access_token" => getSignedJWTForUser($email),
      ]);
    } catch (Exception $exception) {
      return $this->getResponse(
        [
          "error" => $exception->getMessage(),
        ],
        $responseCode,
      );
    }
  }

  private function setUserOrder($userId): void
  {
    if ($this->session) {
      $orderModel = new \App\Models\OrderModel();
      $orderModel->setUserOrder($this->session, $userId);
    }
  }

  public function create()
  {
    try {
      $this->setDataForSave();
      $this->sendEmailActivation();
      return $this->getResponse(
        ["return" => "success", "message" => "Solictação enviada com sucesso."],
        ResponseInterface::HTTP_CREATED,
      );
    } catch (Exception $e) {
      return $this->getResponse(
        ["return" => "danger", "message" => $e->getMessage()],
        ResponseInterface::HTTP_BAD_REQUEST,
      );
    }
  }

  public function passwordRecovery()
  {
    try {
      $data = $this->request->getJsonVar("data");
      $user = $this->userModel->findUserByEmail($data->email);

      $this->emailPasswordRecoverySend($user, $this->emailPasswordRecoveryInsert($user));
      return $this->getResponse([
        "return" => "success",
        "message" => "Solictação enviada com sucesso.",
      ]);
    } catch (Exception $e) {
      return $this->getResponse(
        ["return" => "danger", "message" => $e->getMessage()],
        ResponseInterface::HTTP_BAD_REQUEST,
      );
    }
  }

  public function resetPassword()
  {
    try {
      $data = $this->request->getJsonVar("data");
      $userId = $this->hasAllowedResetPassword($data->token, $data->userData);

      $newPassword = new \App\Entities\User([
        "id" => $userId,
        "password" => $data->password,
      ]);
      $this->userModel->save($newPassword);

      return $this->getResponse([
        "return" => "success",
        "message" => "Senha atualizada com sucesso.",
      ]);
    } catch (Exception $e) {
      return $this->getResponse(
        ["return" => "danger", "message" => $e->getMessage()],
        ResponseInterface::HTTP_BAD_REQUEST,
      );
    }
  }

  private function profileSave()
  {
    if ($this->profileModel->save($this->dataSave) !== false) {
      return $this->profileModel->getInsertID();
    }

    return $this->getResponse(
      ["return" => "warning", "message" => errors($this->profileModel->errors())],
      ResponseInterface::HTTP_OK,
    );
  }

  private function setDataForSave(): void
  {
    $this->dataSave = $this->request->getJSON(true);
    $this->dataSave["username"] = $this->getUsername();
    $this->dataSave["file"] = 1;
    $this->dataSave["role"] = 5;
    $this->dataSave["token"] = random_string("alnum", 8);
    $this->dataSave["active"] = 0;
  }

  private function getUsername()
  {
    $email = $this->dataSave["email"];
    if ($email) {
      $username = explode("@", $email);
      return $username[0];
    }

    return "";
  }

  private function emailPasswordRecoveryInsert($user)
  {
    $token = hash("sha256", uniqid());
    $recovery = new \App\Entities\RecoverPassword([
      "token" => $token,
      "email" => $user->email,
      "user" => $user->id,
    ]);
    $recoveryModel = new \App\Models\RecoverPasswordModel();
    if (!$recoveryModel->save($recovery)) {
      throw new Exception(
        "Não foi possível continuar com a solicitação. [EmailPasswordRecovery01]",
      );
    } else {
      return $token;
    }
  }

  private function hasAllowedResetPassword($token, $userData)
  {
    $recoveryModel = new \App\Models\RecoverPasswordModel();
    $recovery = $recoveryModel->hasRecoveryPassword($token);
    if ($recovery) {
      $user = $this->userModel->find($recovery->user);
      $_userData = sha1($user->updated_at . "|" . $user->email . "|" . $user->id);
      if ($userData === $_userData) {
        return $user->id;
      } else {
        throw new Exception(
          "Não foi encontrada a solicitação para redefinição de senha ou esta expirada. [01]",
        );
      }
    } else {
      throw new Exception(
        "Não foi encontrada a solicitação para redefinição de senha ou esta expirada. [00]",
      );
    }
  }

  private function emailPasswordRecoverySend($user, $token)
  {
    $email = \Config\Services::email();

    $email->setFrom("sistema@cbvl.esp.br", "CBVL Eventos");
    $email->setTo($user->email);

    $linkParams =
      "/" . $token . "/" . sha1($user->updated_at . "|" . $user->email . "|" . $user->id);

    $email->setSubject("CBVL Eventos - Redefinição de Senha");
    $email->setMessage(
      view("email/default", [
        "title" => "Solicitação para redefinição de senha",
        "content" =>
          '
                <h3>Olá! ' .
          $user->profile_name .
          '</h3>
                <p>Foi recebida uma solicitação para alterar a senha da sua conta no sistema de eventos da CBVL.</p>
                <div style="text-align:center">
                    <a href="' .
          base_url("app/authentication/reset-password" . $linkParams) .
          '">Redefinir minha senha</a>
                </div>
                <p>Se você não iniciou esta solicitação, entre em contato conosco imediatamente pelo e-mail contato@cbvl.esp.br.</p>
                <p style="line-height:18px;">
                    Obrigado,<br />
                    Confederação Brasileira de Voo Livre
                </p>
                ',
      ]),
    );

    if (!$email->send(false)) {
      throw new Exception("Houve um problema ao tentar enviar o E-mail. [EmailPasswordRecovery]");
    }
  }

  private function sendEmailActivation()
  {
    $email = \Config\Services::email();

    $email->setFrom("sistema@cbvl.esp.br", "CBVL Eventos");
    $email->setTo("contato@cbvl.com.br");
    $email->setBCC("jbmengue@gmail.com");
    $email->setReplyTo($this->dataSave["email"]);

    $email->setSubject("CBVL Eventos - Solicitação de Acesso");
    $email->setMessage(
      view("email/default", [
        "title" => "Solicitação de Acesso",
        "content" =>
          '
                <ul>
                    <li>Name: ' .
          $this->dataSave["name"] .
          '</li>
                    <li>E-mail: ' .
          $this->dataSave["email"] .
          '</li>
                </ul>
                <p>' .
          $this->dataSave["comments"] .
          "!</p>",
      ]),
    );

    if (!$email->send(false)) {
      throw new Exception("Houve um problema ao tentar realizar a solicitação [EmailActivation]");
    }
  }
}
