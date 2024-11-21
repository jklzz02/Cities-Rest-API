<?php

namespace Jklzz02\RestApi\Middleware;


use Jklzz02\RestApi\Core\Database;
use Jklzz02\RestApi\Core\Request;
use Jklzz02\RestApi\Exception\HTTPException\HTTPUnauthorizedException;
use PDO;

class Auth{

    protected PDO $connection;

    public function __construct(protected Request $request, Database $db)
    {
        $this->connection = $db->getConnection();
    }

    public function handle(): void
    {
        $stmt = $this->connection->prepare("SELECT * FROM tokens WHERE token = :token");
        $stmt->execute([":token" => $this->request->token()]);

        if(!$stmt->fetch()){
            throw new HTTPUnauthorizedException();
        }

    }

}