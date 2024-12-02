<?php

namespace Jklzz02\RestApi\Exception\GatewayException;

use Throwable;

class AlreadyExistsException extends GatewayException{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
