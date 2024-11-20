<?php

namespace Jklzz02\RestApi\Core;

use Jklzz02\RestApi\Exception\Gateway\UnknownColumnsException;

class ExceptionHandler{

    protected Response $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function handle(\Throwable $e): never
    {
        error_log($e);

        switch (get_class($e)) {

            case UnknownColumnsException::class:
                $this->response->badRequest();
                break;

            default:
                $this->response->internalError();
                break;
        }
    }

}