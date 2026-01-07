<?php
namespace App\API;
use App\API\BaseAPIController;
use CodeIgniter\HTTP\ResponseInterface;

class Send extends BaseAPIController
{
  private $mail;

  public function __construct()
  {
    helper("email");
    $this->mail = \Config\Services::email();
    $this->mail->setTo([""]);
    $this->mail->setBCC("jbmengue@gmail.com");
  }

  public function contact()
  {
    $agent = $this->request->getUserAgent();
    $data = $this->request->getJSON();
    $this->mail->setSubject("Contato de " . $data->name);
    $message = <<<EOT
        <div style="line-height: 3">
            Nome: {$data->name}<br />
            Empresa: {$data->company}<br />
            Telefone: {$data->phone}<br />
            E-mail: {$data->email}<br />
            Demanda: {$data->subject}<br />
            {$data->message}<br /><br />
        </div>
        <hr />
        <small>
        Browser: {$agent->getBrowser()}<br />
        System: {$agent->getPlatform()}<br />
        Agent: {$agent->getAgentString()}<br />
        IP: {$this->request->getIPAddress()}
        </small>
    EOT;
    $this->mail->setMessage($message);
    $this->mail->setReplyTo($data->email);
    if (!$this->mail->send()) {
      return $this->getResponse([
        "return" => "danger",
        "message" => "Ocorreu um problema ao enviar os seus dados. Sentimos muito pelo transtorno.",
      ]);
    }

    return $this->getResponse(
      [
        "return" => "success",
        "message" =>
          "Recebemos seu contato. Nossa equipe entrará em contato o mais breve possível!",
      ],
      ResponseInterface::HTTP_OK,
    );
  }
}
