<?php

namespace Jklzz02\RestApi\Core;

use Jklzz02\RestApi\Exception\GatewayException\UnknownColumnException;

class ExceptionHandler{

    public function __construct(protected Responder $responder)
    {
    }

    public function handle(\Throwable $e): never
    {
        error_log($e);

        switch (get_class($e)) {

            case UnknownColumnException::class:
                $this->responder->badRequest();
                break;

            default:
                $this->responder->internalError();
                break;
        }
    }

}