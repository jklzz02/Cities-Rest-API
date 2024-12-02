<?php

namespace Jklzz02\RestApi\Controllers;

use Jklzz02\RestApi\Core\Request;
use Jklzz02\RestApi\Core\Responder;
use Jklzz02\RestApi\Core\Validator;
use Jklzz02\RestApi\Exception\HTTPException\HTTPBadRequestException;
use Jklzz02\RestApi\Exception\HTTPException\HTTPNotFoundException;
use Jklzz02\RestApi\Gateways\CitiesTableGateway;

class CitiesController extends Controller
{
    public function __construct(protected CitiesTableGateway $gateway,
                                protected Responder $responder,
                                protected Validator $validator)
    {
    }

    protected function handleGet(Request $request): never
    {
        $params = $request->getQuery();

        if($params["id"] ?? false){
            $this->validateId($params["id"]);
        }

        $result = $this->gateway->findAll($params);
        
        if(empty($result)){
            
            throw new HTTPNotFoundException();
        }

        $this->responder->success(data: $result);
    }

    protected function handlePost(Request $request): never
    {
        $data = $request->getBody();

        $this->validateFields($data, $this->gateway::ALLOWED_COLUMNS, ["id"]);
        
        $this->gateway->insert($data);
        $this->responder->created();
    }

    protected function handlePatch(Request $request): never
    {
        $params = $request->getQuery();
        $data = $request->getBody();

        $this->validateId($params["id"]);

        $this->gateway->update($params['id'], $data);
        $this->responder->success("Resource Updated");

    }

    protected function handlePut(Request $request): never
    {
        $params = $request->getQuery();
        $data = $request->getBody();

        $this->validateId($params['id'] ?? false);

        $this->validateFields($data, $this->gateway::ALLOWED_COLUMNS);

        $this->gateway->update($params['id'], $data);
        $this->responder->success("Resource Updated");
    }

    protected function handleDelete(Request $request): never
    {
        $params = $request->getQuery();


        $this->validateId($params['id'] ?? false);

        $this->gateway->delete($params['id']);
        $this->responder->success("Resource Deleted");
    }

    private function validateId(mixed $id): void
    {
        if (!$this->validator->integer($id)) {
            
            throw new HTTPBadRequestException("Invalid id");
        }
    }

    private function validateFields(array $data, array $requiredFields, array $optionalFields = []): void
    {
        $missing = $this->validator->array($data, $requiredFields, $optionalFields);
        if ($missing){
            throw new HTTPBadRequestException($missing);
        }
    }

}
