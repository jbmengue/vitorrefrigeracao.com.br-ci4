<?php

use CodeIgniter\Router\RouteCollection;

use App\Controllers\Home;
use App\Controllers\Contact;
use App\Controllers\Page;
use App\Controllers\Maintenance;

use App\API\Authentication;
use App\API\Post;
use App\API\Send;

use App\API\Admin\User as UserAdmin;
use App\API\Admin\Post as PostAdmin;
use App\API\TechnicalServices;

/**
 * @var RouteCollection $routes
 */
$routes->get("/", [Home::class, "index"]);
$routes->get("contato", [Contact::class, "index"]);
$routes->get("news(:any)", [Page::class, "news"]);
$routes->get("maintenance", [Maintenance::class, "index"]);

$routes->group("api", ["namespace" => "App\API"], static function ($routes) {
  $routes->post("authentication", [Authentication::class, "index"]);
  $routes->post("sendPasswordRecovery", [Authentication::class, "passwordRecovery"]);
  $routes->post("resetPassword", [Authentication::class, "resetPassword"]);

  $routes->get("post", [Post::class, "index"]);
  $routes->get("post/by-slug", [Post::class, "bySlug"]);
  $routes->get("post/related", [Post::class, "related"]);
  $routes->get("post/events-dates", [Post::class, "eventsDates"]);
  $routes->post("send/contact", [Send::class, "contact"]);

  $routes->get('technical-services', [TechnicalServices::class, 'index']);

  $routes->group("admin", ["namespace" => "App\API\Admin"], static function ($routes) {
    $routes->get("user/role", [UserAdmin::class, "role"]);
    $routes->get("user/by-role/(:segment)", [UserAdmin::class, "byRole"]);
    $routes->post("user/photo", [UserAdmin::class, "photo"]);
    $routes->post("post/reorder", [PostAdmin::class, "reorder"]);
    $routes->get("post/(:num)/categories", [PostAdmin::class, "categories"]);
    $routes->resource("user");
    $routes->resource("post");
    $routes->resource("category");
    $routes->resource("status");
    $routes->resource("file");
  });
});
