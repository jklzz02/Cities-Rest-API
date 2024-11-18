<?php

namespace Jklzz02\RestApi\Middleware;

use Jklzz02\RestApi\Core\App;

class MiddleWare{

    protected const array MAP = [
        Auth::class
    ];

    public static function resolve(?string $middleware): void
    {

        if(!in_array($middleware, static::MAP)){

            throw new \Exception("No matching middleware found for '$middleware' ");
        }

        App::resolve($middleware)->handle();
    }

}