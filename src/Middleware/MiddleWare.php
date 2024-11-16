<?php

namespace Jklzz02\RestApi\Middleware;

use Jklzz02\RestApi\Core\App;

class MiddleWare{

    protected const array MAP = [

        "auth" => Auth::class
    ];

    public static function resolve(string|null $key): void
    {
        if(!$key){
            return;
        }

        $middleware = MiddleWare::MAP[$key];

        if(!$middleware){

            throw new \Exception("No matching middleware found for '$key' ");
        }

        App::resolve($middleware)->handle();
    }

}