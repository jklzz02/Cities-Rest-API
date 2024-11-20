<?php

namespace Jklzz02\RestApi\Controllers;

use Jklzz02\RestApi\Core\Request;
use Jklzz02\RestApi\Core\Response;
use Jklzz02\RestApi\Core\Validator;
use Jklzz02\RestApi\Gateways\CitiesTableGateway;

class CitiesController extends Controller
{
    protected CitiesTableGateway $gateway;
    protected Response $response;
    protected Validator $validator;

    public function __construct(CitiesTableGateway $gateway, Response $response, Validator $validator)
    {
        $this->gateway = $gateway;
        $this->response = $response;
        $this->validator = $validator;
    }

    protected function handleGet(Request $request): void
    {
        $params = $request->getQuery();

        if(isset($params["id"])){
            $this->validateId($params['id']);
            $result = $this->gateway->find($params['id']);
        }
        
        if(!empty($params) && !key_exists('id', $params)){
           $result = $this->gateway->findAll($params);
        }
        

        if(!isset($result)) $this->response->notFound();

        $this->response->success(data: $result);
    }

    protected function handlePost(Request $request): void
    {
        $data = $request->getBody();

        $this->validateFields($data, ['name', 'population', 'country', 'lat', 'lon']);
        
        $this->gateway->insert($data);
        $this->response->created();
    }

    protected function handlePatch(Request $request): void
    {
        $params = $request->getQuery();
        $data = $request->getBody();

        $this->validateId($params["id"]);

        if(!$this->gateway->update($params['id'], $data)){

            $this->response->notFound("Cannot Update Resource Not Found");
        }

        $this->gateway->update($params['id'], $data);
        $this->response->success("Resource Updated");

    }

    protected function handlePut(Request $request): void
    {
        $params = $request->getQuery();
        $data = $request->getBody();

        $this->validateId($params['id'] ?? false);

        $this->validateFields($data, ['name', 'country', 'population', 'lat', 'lon']);

        if(!$this->gateway->update($params['id'], $data)){

            $this->response->notFound("Cannot Update Resource Not Found");
        }

        $this->response->success("Resource Updated");
    }

    protected function handleDelete(Request $request): void
    {
        $params = $request->getQuery();


        $this->validateId($params['id'] ?? false);

        if (!$this->gateway->delete($params['id'])) {

            $this->response->notFound("Cannot Delete resource Not Found");
        }


        $this->response->success("Resource Deleted");
    }

    private function validateId(mixed $id): void
    {
        if (!$this->validator->integer($id)) {
            $this->response->badRequest("Invalid id");
        }
    }

    private function validateFields(array $data, array $requiredFields): void
    {
        $missing = $this->validator->array($data, $requiredFields);
        if ($missing) $this->response->badRequest($missing);
    }

}
