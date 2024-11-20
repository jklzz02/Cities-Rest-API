<?php

namespace Jklzz02\RestApi\Interfaces;


use Jklzz02\RestApi\Core\Request;

abstract class Controller
{
    public function handle(Request $request): void
    {
        switch($request->getMethod()){
            case "GET":
                $this->handleGet($request);
                break;
            case "POST":
                $this->handlePost($request);
                break;
            case "PATCH":
                $this->handlePatch($request);
            case "PUT":
                $this->handlePut($request);
                break;
            case "DELETE":
                $this->handleDelete($request);
                break;   
        }

    }

    protected abstract function handleGet(Request $request): void;
    protected abstract function handlePost(Request $request): void;
    protected abstract function handlePatch(Request $reuqest) :void;
    protected abstract function handlePut(Request $request): void;
    protected abstract function handleDelete(Request $request): void;

}