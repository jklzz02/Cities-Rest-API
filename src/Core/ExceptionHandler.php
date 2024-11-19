<?php

namespace Jklzz02\RestApi\Core;

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

            case \InvalidArgumentException::class:
                $this->response->badRequest();
                break;

            default:
                $this->response->internalError();
                break;
        }
    }

}