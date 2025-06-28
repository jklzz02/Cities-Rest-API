<?php

namespace Jklzz02\RestApi\Core;

use Jklzz02\RestApi\Exception\ContainerException\NotFoundException;
use Jklzz02\RestApi\Interfaces\ContainerInterface;

class Container implements ContainerInterface {

    protected array $bindings = [];
    protected array $instances = [];

    public function set(string $key, callable $resolver): void
    {
        $this->bindings[$key] = $resolver;
    }

    public function setSingleton(string $key, callable $resolver): void
    {
        $this->set($key, $resolver);

        if (!array_key_exists($key, $this->instances))
        {
            $this->instances[$key] = call_user_func($resolver);
        }
    }

    public function get(string $key): object
    {
        if (array_key_exists($key, $this->instances))
        {
            return $this->instances[$key];
        }

        if (!array_key_exists($key, $this->bindings))
        {
            throw new NotFoundException("No matching binding found for '$key'");
        }

        $resolver = $this->bindings[$key];
        return call_user_func($resolver);
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->bindings);
    }
}