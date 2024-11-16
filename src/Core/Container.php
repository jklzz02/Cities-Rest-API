<?php

namespace Jklzz02\RestApi\Core;

class Container{

    protected array $bindings=[];

    public function bind(string $key, callable $resolver):void
    {
        $this->bindings[$key] = $resolver;
    }

    public function resolve(string $key){

        if (!array_key_exists($key, $this->bindings)){

            throw new \Exception("No matching binding found for '$key'");

        }

        $resolver = $this->bindings[$key];
        return call_user_func($resolver);

    }

    public function getBindings():array
    {
        return $this->bindings;
    }

}