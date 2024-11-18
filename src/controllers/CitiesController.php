<?php

namespace Jklzz02\RestApi\controllers;

use Jklzz02\RestApi\Core\Response;
use \Jklzz02\RestApi\Core\Request;
use Jklzz02\RestApi\gateways\CitiesTableGateway;
use Jklzz02\RestApi\interfaces\Controller;

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

        if ($params['id'] ?? false) {

            $result = $this->gateway->find((int)$params['id']);
        }
        elseif ($params['name'] ?? false) {

            $result = $this->gateway->findAllByName($params['name']);
        }
        elseif ($params['country']) {
            $result = $this->gateway->findAllByCountry($params['country']);
        }
        elseif ($params['lat'] ?? false && $params['lon'] ?? false) {
            
            $result = $this->gateway->findAll([
                'lat' => $params['lat'],
                'lon' => $params['lon']
            ]);
        }


        if(!$result){

            $this->response->notFound();
        }

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

        if (!isset($params['id'])) {

            $this->response->badRequest("ID is required");
        }


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

        if (!isset($params['id'])) {

            $this->response->badRequest("ID is required");
        }

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

        if (!isset($params['id'])) {

            $this->response->badRequest("ID is required");
        }

        if (!$this->gateway->delete((int)$params['id'])) {

            $this->response->notFound("Cannot Delete resource with ID: {$params['id']} Not Found");
        }


        $this->response->success("Resource Deleted");
    }

}
