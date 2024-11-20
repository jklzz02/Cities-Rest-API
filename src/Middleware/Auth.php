<?php

namespace Jklzz02\RestApi\Middleware;


use Jklzz02\RestApi\Core\Database;
use Jklzz02\RestApi\Core\Request;
use Jklzz02\RestApi\Core\Responder;
use PDO;

class Auth{

    protected PDO $connection;
    protected string $token;
    protected Responder $responder;

    public function __construct(Request $request, Responder $responder, Database $db)
    {
        $this->connection = $db->getConnection();
        $this->token = $request->token();
        $this->responder = $responder;
    }

    public function handle(): void
    {
        $stmt = $this->connection->prepare("SELECT * FROM tokens WHERE token = :token");
        $stmt->execute([":token" => $this->token]);

        if(!$stmt->fetch()){
            $this->responder->unauthorized();
        }

    }

}