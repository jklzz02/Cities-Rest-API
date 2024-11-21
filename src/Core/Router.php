<?php

namespace Jklzz02\RestApi\Core;


use Jklzz02\RestApi\Controllers\Controller;
use Jklzz02\RestApi\Enum\HTTPMethod;
use Jklzz02\RestApi\Exception\HTTPException\HTTPNotFoundException;
use Jklzz02\RestApi\Middleware\Auth;
use Jklzz02\RestApi\Middleware\MiddleWare;

class Router
{
    protected array $routes = [];

    public function add(HTTPMethod $method, string $path, Controller $controller) :static
    {
        $this->routes[] = [
            "method" => $method->value,
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

        throw new HTTPNotFoundException();
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

}