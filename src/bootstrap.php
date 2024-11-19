<?php


use Jklzz02\RestApi\Controllers\CitiesController;
use Jklzz02\RestApi\Core\App;
use Jklzz02\RestApi\Core\Container;
use Jklzz02\RestApi\Core\Database;
use Jklzz02\RestApi\Core\ExceptionHandler;
use Jklzz02\RestApi\Core\Request;
use Jklzz02\RestApi\Core\Response;
use Jklzz02\RestApi\Core\Validator;
use Jklzz02\RestApi\Gateways\CitiesTableGateway;
use Jklzz02\RestApi\Middleware\Auth;

$config = require BASE_PATH . "src/config.php";

$container = new Container();

$container->bind(Database::class, fn () => new Database($config["database"]));
$container->bind(ExceptionHandler::class, fn () => new ExceptionHandler(new Response));
$container->bind(Auth::class, fn () => new Auth(new Request, new Response, $container->resolve(Database::class)));
$container->bind(CitiesTableGateway::class, fn () => new CitiesTableGateway($container->resolve(Database::class)));
$container->bind(CitiesController::class, fn () => new CitiesController($container->resolve(CitiesTableGateway::class), new Response, new Validator));


App::setContainer($container);
