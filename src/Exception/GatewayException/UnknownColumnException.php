<?php

namespace Jklzz02\RestApi\Exception\GatewayException;

use Jklzz02\RestApi\Exception\GatewayException\GatewayException;
use Throwable;

class UnknownColumnException extends GatewayException{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}