<?php

namespace Jklzz02\RestApi\Interfaces;

interface ContainerInterface
{
    public function get(string $key): object;
    public function has(string $key): bool;
}