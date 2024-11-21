<?php

namespace Jklzz02\RestApi\Controllers;


use Jklzz02\RestApi\Core\Request;
use Jklzz02\RestApi\Enum\HTTPMethod;

abstract class Controller
{
    public function handle(Request $request): never
    {
        switch (HTTPMethod::from($request->getMethod())) {

            case HTTPMethod::GET:
                $this->handleGet($request);
                break;

            case HTTPMethod::POST:
                $this->handlePost($request);
                break;

            case HTTPMethod::PATCH:
                $this->handlePatch($request);
                break;

            case HTTPMethod::PUT:
                $this->handlePut($request);
                break;
                
            case HTTPMethod::DELETE:
                $this->handleDelete($request);
                break;
        }

    }

    protected abstract function handleGet(Request $request): never;
    protected abstract function handlePost(Request $request): never;
    protected abstract function handlePatch(Request $request) :never;
    protected abstract function handlePut(Request $request): never;
    protected abstract function handleDelete(Request $request): never;

}