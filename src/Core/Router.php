<?php

namespace Jklzz02\RestApi\Core;


use Jklzz02\RestApi\Interfaces\Controller;
use Jklzz02\RestApi\Middleware\Auth;
use Jklzz02\RestApi\Middleware\MiddleWare;

class Router
{
    protected array $routes = [];
    public const int DEFAULT_ERRORE_CODE = 404;
    public const string DEFAULT_ERROR_MESSAGE = "Resource Not Found";

    public function add(string $method, string $path, Controller $controller) :static
    {
        $this->routes[] = [

            "method" => $method,
            "path" => $path,
            "controller" => $controller,
            "middleware" => null

        ];

        return $this;
    }

    public function auth() :void
    {
       $route = array_key_last($this->routes);
       $this->routes[$route]["middleware"] = Auth::class; 
    }

    public function dispatch(Request $request): void
    {
        $method = $request->getMethod();
        $path = $request->getPath();


        foreach($this->routes as $route){

            if($route["method"] === $method && $route["path"] === $path){

                if($route["middleware"] ?? false){

                   MiddleWare::resolve($route["middleware"]);
                }

             $route["controller"]->handle($request);
            
            }
        }

        $this->abort(static::DEFAULT_ERRORE_CODE, static::DEFAULT_ERROR_MESSAGE);
    }

    private function abort(int $status, string $message): void
    {
        http_response_code($status);
        echo json_encode([
            "status" => $status,
            "message" => $message
        ]);

        die();
    }

}
