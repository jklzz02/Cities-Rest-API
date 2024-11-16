<?php

namespace Jklzz02\RestApi\Core;

use PDO;

class Database
{
    protected PDO $connection;

    public function __construct(string $path)
    {
        try {
            $this->connection = new PDO(
                "sqlite:$path",
                '',
                '',
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (\PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
