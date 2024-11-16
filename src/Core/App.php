<?php

namespace Jklzz02\RestApi\Core;

class App {

    protected static Container $container;

    public static function setContainer(Container $container):void
    {
        static::$container = $container;
    }

    public static function Container():Container
    {
        return static::$container;
    }

    public static function resolve(string $key):object
    {
       return App::$container->resolve($key);
    }

}