<?php

namespace Jklzz02\RestApi\Exception\Gateway;

use Throwable;

class GatewayException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null){
        parent::__construct($message, $code, $previous);
    }
}