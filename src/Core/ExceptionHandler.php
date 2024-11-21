<?php

namespace Jklzz02\RestApi\Core;

use Jklzz02\RestApi\Exception\GatewayException\RecordNotFoundException;
use Jklzz02\RestApi\Exception\GatewayException\UnknownColumnException;
use Jklzz02\RestApi\Exception\HTTPException\HTTPBadRequestException;
use Jklzz02\RestApi\Exception\HTTPException\HTTPNotFoundException;
use Jklzz02\RestApi\Exception\HTTPException\HTTPUnauthorizedException;

class ExceptionHandler{

    public function __construct(protected Responder $responder)
    {
    }

    public function handle(\Throwable $e): never
    {

        switch (get_class($e)) {

            case HTTPBadRequestException::class:
                $this->responder->badRequest($e->getMessage());
                break;

            case HTTPUnauthorizedException::class:
                error_log("WARNING: " . $e->getMessage());
                $this->responder->unauthorized();
                break;

            case HTTPNotFoundException::class:
                $this->responder->notFound();
                break;

            case RecordNotFoundException::class:
                $this->responder->notFound();
                break;

            case UnknownColumnException::class:
                error_log("WARNING: " . $e->getMessage());
                $this->responder->badRequest();
                break;

            default:
            
                error_log($e);
                $this->responder->internalError();
                break;
        }
    }

}