<?php

namespace Jklzz02\RestApi\Core;

use PDO;

class Database
{
    protected PDO $connection;

    public function __construct(array $config)
    {

        $this->connection = new PDO(
            $this->dsn($config),
            $config["username"] ?? '',
            $config["password"] ?? '',
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
    }

    protected function dsn(array $config) : string
    {
        $type = $config["type"] ?? "sqlite";

        $dsn = match($type){
            "mysql", "pgsql" => "$type:host={$config['host']};port={$config['port']};dbname={$config['name']}",
            "sqlsrv" => "sqlsrv:Server={$config['host']},{$config['port']};Database={$config['name']}",
            "sqlite" => "sqlite:" . BASE_PATH  . $config["name"],
        };

        return $dsn;
    }


    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
