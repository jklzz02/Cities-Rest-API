<?php

namespace Jklzz02\RestApi\Controllers;

use Jklzz02\RestApi\Core\Request;
use Jklzz02\RestApi\Core\Responder;
use Jklzz02\RestApi\Core\Validator;
use Jklzz02\RestApi\Gateways\CitiesTableGateway;

class CitiesController extends Controller
{
    public function __construct(protected CitiesTableGateway $gateway,
                                protected Responder $responder,
                                protected Validator $validator)
    {
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
        

        if(!isset($result)) $this->responder->notFound();

        $this->responder->success(data: $result);
    }

    protected function handlePost(Request $request): void
    {
        $data = $request->getBody();

        $this->validateFields($data, ['name', 'population', 'country', 'lat', 'lon']);
        
        $this->gateway->insert($data);
        $this->responder->created();
    }

    protected function handlePatch(Request $request): void
    {
        $params = $request->getQuery();
        $data = $request->getBody();

        $this->validateId($params["id"]);

        if(!$this->gateway->update($params['id'], $data)){

            $this->responder->notFound("Cannot Update Resource Not Found");
        }

        $this->gateway->update($params['id'], $data);
        $this->responder->success("Resource Updated");

    }

    protected function handlePut(Request $request): void
    {
        $params = $request->getQuery();
        $data = $request->getBody();

        $this->validateId($params['id'] ?? false);

        $this->validateFields($data, ['name', 'country', 'population', 'lat', 'lon']);

        if(!$this->gateway->update($params['id'], $data)){

            $this->responder->notFound("Cannot Update Resource Not Found");
        }

        $this->responder->success("Resource Updated");
    }

    protected function handleDelete(Request $request): void
    {
        $params = $request->getQuery();


        $this->validateId($params['id'] ?? false);

        if (!$this->gateway->delete($params['id'])) {

            $this->responder->notFound("Cannot Delete resource Not Found");
        }


        $this->responder->success("Resource Deleted");
    }

    private function validateId(mixed $id): void
    {
        if (!$this->validator->integer($id)) {
            $this->responder->badRequest("Invalid id");
        }
    }

    private function validateFields(array $data, array $requiredFields): void
    {
        $missing = $this->validator->array($data, $requiredFields);
        if ($missing) $this->responder->badRequest($missing);
    }

}
