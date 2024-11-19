<?php

namespace Jklzz02\RestApi\Controllers;

use Jklzz02\RestApi\Core\Response;
use Jklzz02\RestApi\Core\Request;
use Jklzz02\RestApi\Gateways\CitiesTableGateway;
use Jklzz02\RestApi\Interfaces\Controller;

class CitiesController extends Controller
{
    protected CitiesTableGateway $gateway;
    protected Response $response;

    public function __construct(CitiesTableGateway $gateway, Response $response)
    {
        $this->gateway = $gateway;
        $this->response = $response;
    }

    protected function handleGet(Request $request): void
    {
        $params = $request->getQuery();

        $result = match(true){
            isset($params['id']) && array_keys($params) === ['id'] => $this->gateway->find((int)$params['id']),
            !empty($params) => $this->gateway->findAll($params),
            default => null
        };

        if(!$result) $this->response->notFound();

        $this->response->success("Resource Retrieved", $result);
    }

    protected function handlePost(Request $request): void
    {
        $data = $request->getBody();

        if (!isset($data['name'], $data['lat'], $data['lon'], $data['population'], $data['country'])) {
           $this->response->badRequest("Missing Data");
        }

        $this->gateway->insert($data);
        $this->response->created();
    }

    protected function handlePatch(Request $request): void
    {
        $params = $request->getQuery();
        $data = $request->getBody();

        if (!isset($params['id'])) $this->response->badRequest("ID is required");


        if(!$this->gateway->update((int)$params['id'], $data)){

            $this->response->notFound("Cannot Update Resource with ID: {$params['id']} Not Found");
        }

        $this->gateway->update((int)$params['id'], $data);
        $this->response->success("Resource Upated");

    }

    protected function handlePut(Request $request): void
    {
        $params = $request->getQuery();
        $data = $request->getBody();

        if (!isset($params['id'])) $this->response->badRequest("ID is required");

        if (!isset($data['name'], $data['lat'], $data['lon'], $data['population'], $data['country'])) {
           $this->response->badRequest("Missing Data");
        }

        if(!$this->gateway->update((int)$params['id'], $data)){

            $this->response->notFound("Cannot Update Resource with ID: {$params['id']} Not Found");
        }

        $this->response->success("Resource Upated");
    }

    protected function handleDelete(Request $request): void
    {
        $params = $request->getQuery();

        if (!isset($params['id'])) $this->response->badRequest("ID is required");

        if (!$this->gateway->delete((int)$params['id'])) {

            $this->response->notFound("Cannot Delete resource with ID: {$params['id']} Not Found");
        }


        $this->response->success("Resource Deleted");
    }

}
