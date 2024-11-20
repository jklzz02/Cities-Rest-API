<?php

namespace Jklzz02\RestApi\Exception\Container;

use Throwable;

class ContainerException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}