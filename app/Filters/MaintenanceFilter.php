<?php
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class MaintenanceFilter implements FilterInterface
{
  private $appConfig;
  private $session;
  protected $request;

  public function __construct()
  {
    $this->appConfig = appConfig();
    $this->session = \Config\Services::session();
  }

  public function before(RequestInterface $request, $arguments = null)
  {
    $this->request = $request;
    if ($this->hasDownForMaintenance() && !$this->isAllowed()) {
      return $this->showMaintenance();
    }
  }

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
  {
    // Do something here
  }

  private function hasDownForMaintenance()
  {
    return $this->appConfig->downForMaintenance;
  }

  private function showMaintenance()
  {
    return redirect()->to($this->appConfig->downForMaintenanceRedirect);
  }

  private function isAllowed()
  {
    if ($this->session->envToken === $this->appConfig->downForMaintenanceToken) {
      return true;
    } else {
      $envToken = $this->request->getGet("env");
      if ($envToken === $this->appConfig->downForMaintenanceToken) {
        $this->setSessionToken($envToken);
        return true;
      }
      return false;
    }
  }

  private function setSessionToken($envToken)
  {
    $this->session->set(["envToken" => $envToken]);
  }
}
