<?php

namespace Jklzz02\RestApi\Controllers;

use Jklzz02\RestApi\Core\Response;
use Jklzz02\RestApi\Core\Request;
use Jklzz02\RestApi\Core\Validator;
use Jklzz02\RestApi\Gateways\CitiesTableGateway;
use Jklzz02\RestApi\Interfaces\Controller;

class CitiesController extends Controller
{
    protected CitiesTableGateway $gateway;
    protected Response $response;
    protected Validator $validator;

    public function __construct(CitiesTableGateway $gateway, Response $response, Validator $validator)
    {
        $this->gateway = $gateway;
        $this->response = $response;
    }

    protected function handleGet(Request $request): void
    {
        $params = $request->getQuery();

        $result = match(true){
            $this->validateId($params['id'] ?? false) => $this->gateway->find($params['id']),
            !empty($params) && !key_exists('id', $params) => $this->gateway->findAll($params),
            default => null
        };

        if(!$result) $this->response->notFound();

        $this->response->success("Resource Retrieved", $result);
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

            $this->response->notFound("Cannot Update Resource");
        }

        $this->gateway->update($params['id'], $data);
        $this->response->success("Resource Upated");

    }

    protected function handlePut(Request $request): void
    {
        $params = $request->getQuery();
        $data = $request->getBody();

        $this->validateId($params['id'] ?? false);

        $this->validateFields($data, ['name', 'country', 'population', 'lat', 'lon']);

        if(!$this->gateway->update($params['id'], $data)){

            $this->response->notFound("Cannot Update Resource");
        }

        $this->response->success("Resource Upated");
    }

    protected function handleDelete(Request $request): void
    {
        $params = $request->getQuery();


        $this->validateId($params['id'] ?? false);

        if (!$this->gateway->delete($params['id'])) {

            $this->response->notFound("Cannot Delete resource with ID: {$params['id']}. Not Found");
        }


        $this->response->success("Resource Deleted");
    }

    private function validateId(mixed $id): bool
    {
        if (!$this->validator->integer($id)) {
            $this->response->badRequest("Invalid id");
            return false;
        }
        return true;
    }

    private function validateFields(array $data, array $requiredFields): never
    {
        $missing = $this->validator->array($data, $requiredFields);
        if ($missing) $this->response->badRequest($missing);
    }

}
