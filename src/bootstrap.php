<?php


use Jklzz02\RestApi\Controllers\CitiesController;
use Jklzz02\RestApi\Core\App;
use Jklzz02\RestApi\Core\Container;
use Jklzz02\RestApi\Core\Database;
use Jklzz02\RestApi\Core\ExceptionHandler;
use Jklzz02\RestApi\Core\Request;
use Jklzz02\RestApi\Core\Responder;
use Jklzz02\RestApi\Core\Validator;
use Jklzz02\RestApi\Gateways\CitiesTableGateway;
use Jklzz02\RestApi\Middleware\Auth;

$config = require BASE_PATH . "src/config.php";

$container = new Container();

$container->set(Database::class, fn () => new Database($config["database"]));
$container->set(ExceptionHandler::class, fn () => new ExceptionHandler(new Responder));
$container->set(Auth::class, fn () => new Auth(new Request, new Responder, $container->get(Database::class)));
$container->set(CitiesTableGateway::class, fn () => new CitiesTableGateway($container->get(Database::class)));
$container->set(CitiesController::class, fn () => new CitiesController($container->get(CitiesTableGateway::class), new Responder, new Validator));


App::setContainer($container);
