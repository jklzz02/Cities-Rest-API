<?php

declare(strict_types=1);

use Jklzz02\RestApi\Controllers\CitiesController;
use Jklzz02\RestApi\Core\App;
use Jklzz02\RestApi\Core\ExceptionHandler;
use Jklzz02\RestApi\Core\Request;
use Jklzz02\RestApi\Core\Router;
use Jklzz02\RestApi\Enum\HTTPMethod;

const BASE_PATH = __DIR__ . "/../";
require_once BASE_PATH . "vendor/autoload.php";
require_once BASE_PATH . "src/bootstrap.php";

$exceptionHandler = App::resolve(ExceptionHandler::class);

set_exception_handler([$exceptionHandler, "handle"]);

$request = new Request();
$router = new Router();

$citiesController = App::resolve(CitiesController::class);

$router->add(HTTPMethod::GET, '/v1/cities', $citiesController);
$router->add(HTTPMethod::POST, '/v1/cities', $citiesController)->auth();
$router->add(HTTPMethod::PATCH, '/v1/cities', $citiesController)->auth();
$router->add(HTTPMethod::PUT, '/v1/cities', $citiesController)->auth();
$router->add(HTTPMethod::DELETE, '/v1/cities', $citiesController)->auth();

$router->dispatch($request);
