<?php


use Jklzz02\RestApi\controllers\CitiesController;
use Jklzz02\RestApi\Core\App;
use Jklzz02\RestApi\Core\Container;
use Jklzz02\RestApi\Core\Database;
use Jklzz02\RestApi\Core\Request;
use Jklzz02\RestApi\Core\Response;
use Jklzz02\RestApi\gateways\CitiesTableGateway;
use Jklzz02\RestApi\Middleware\Auth;

$config = require BASE_PATH . "src/config.php";

$container = new Container();

$container->bind(Database::class, fn () => new Database(BASE_PATH . $config["database"]));
$container->bind(Auth::class, fn () => new Auth(new Request, new Response, $container->resolve(Database::class)));
$container->bind(CitiesTableGateway::class, fn () => new CitiesTableGateway($container->resolve(Database::class)));
$container->bind(CitiesController::class, fn () => new CitiesController($container->resolve(CitiesTableGateway::class), new Response));


App::setContainer($container);
