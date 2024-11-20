<?php

namespace Jklzz02\RestApi\Exception\Gateway;

use Jklzz02\RestApi\Exception\Gateway\GatewayException;
use Throwable;

class UnknownColumnException extends GatewayException{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}