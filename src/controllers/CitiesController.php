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
        elseif ($params['city'] ?? false) {

            $result = $this->gateway->findAllByName($params['city']);
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

        if(!$this->gateway->insert($data)){
            $this->response->internalError();
        }

        $this->response->created();
    }

    protected function handlePut(Request $request): void
    {
        $params = $request->getQuery();
        $data = $request->getBody();

        if (!isset($params['id'])) {

            $this->response->badRequest("ID is required");
        }

        if(!$this->gateway->update((int)$params['id'], $data)){

            $this->response->internalError();
        }
        
        $this->response->success("Resource Upated");

    }

    protected function handleDelete(Request $request): void
    {
        $params = $request->getQuery();

        if (!isset($params['id'])) {

            $this->response->badRequest("ID is required");
        }

        if(!$this->gateway->delete((int)$params['id'])){
            $this->response->internalError();
        }

        $this->response->success("Resource Deleted");
    }

}
