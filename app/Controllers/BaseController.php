<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
  /**
   * Instance of the main Request object.
   *
   * @var CLIRequest|IncomingRequest
   */
  protected $request;

  /**
   * An array of helpers to be loaded automatically upon
   * class instantiation. These helpers will be available
   * to all other controllers that extend BaseController.
   *
   * @var list<string>
   */
  protected $helpers = ["base", "assets", "number"];

  /**
   * Be sure to declare properties for any property fetch you initialized.
   * The creation of dynamic property is deprecated in PHP 8.2.
   */
  // protected $session;

  protected array $data = [];
  protected string $contentView = 'layouts/content';
  protected \Config\App $appConfig;

  /**
   * @return void
   */
  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger,
  ) {
    // Do Not Edit This Line
    parent::initController($request, $response, $logger);
    $this->appConfig = appConfig();
    service('renderer')->setVar('appConfig', $this->appConfig); 
    // Preload any models, libraries, etc, here.

    // E.g.: $this->session = service('session');
  }

  protected function render(array $data = []): string
  {
    $data = array_replace($this->data, $data);

    return view($this->contentView, $data);
  }
}
