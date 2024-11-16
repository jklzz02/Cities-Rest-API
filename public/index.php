<?php

declare(strict_types=1);

use Jklzz02\RestApi\controllers\CitiesController;
use Jklzz02\RestApi\Core\App;
use Jklzz02\RestApi\Core\Request;
use Jklzz02\RestApi\Core\Router;

const BASE_PATH = __DIR__ . "/../";
require_once BASE_PATH . "vendor/autoload.php";
require_once BASE_PATH . "src/bootstrap.php";

header("content-type: application/json");

$request = new Request();
$router = new Router();

$citiesController = App::resolve(CitiesController::class);

$router->add('GET', '/v1/cities', $citiesController);
$router->add('POST', '/v1/cities', $citiesController)->auth();
$router->add('PATCH', '/v1/cities', $citiesController)->auth();
$router->add('PUT', '/v1/cities', $citiesController)->auth();
$router->add('DELETE', '/v1/cities', $citiesController)->auth();

$router->dispatch($request);
