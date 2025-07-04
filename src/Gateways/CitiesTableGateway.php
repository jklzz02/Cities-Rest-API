<?php

namespace Jklzz02\RestApi\Gateways;

use Jklzz02\RestApi\Core\Database;
use Jklzz02\RestApi\Exception\GatewayException\AlreadyExistsException;
use Jklzz02\RestApi\Exception\GatewayException\RecordNotFoundException;
use Jklzz02\RestApi\Exception\GatewayException\UnknownColumnException;
use Jklzz02\RestApi\Interfaces\GatewayInterface;
use PDO;

class CitiesTableGateway implements GatewayInterface
{
    protected PDO $connection;
    public const array ALLOWED_COLUMNS = ['id', 'name', 'lat', 'lon', 'population', 'country'];
    protected const INVALID_ID = -1;

    public function __construct(Database $database)
    {
        $this->connection = $database->getConnection();
    }

    public function find(int $id): array
    {
        $stmt = $this->connection->prepare("SELECT * FROM cities WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch() ?: [];
    }

    public function findAll(array $conditions = []): array
    {

        $this->validate($conditions);

        $query = "SELECT * FROM cities";
        $params = [];

        if (!empty($conditions)) {
            $clauses = [];
            foreach ($conditions as $key => $value) {
                $clauses[] = "$key COLLATE NOCASE = :$key ";
                $params[":$key"] = $value;
            }
            $query .= ' WHERE ' . implode(' AND ', $clauses);
        }

        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function insert(array $data): bool
    {
        $this->validate($data);

        if($this->checkId($data["id"] ?? static::INVALID_ID)){

                throw new AlreadyExistsException();
        }

        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_map(fn($key) => ":$key", array_keys($data)));

        $stmt = $this->connection->prepare("INSERT INTO cities ($columns) VALUES ($placeholders)");
        return $stmt->execute($data);
    }

    public function update(int $id, array $data): bool
    {
        $this->validate($data);
        
        if(!$this->checkId($id)){
            throw new RecordNotFoundException();
        }

        $setClause = implode(', ', array_map(fn($key) => "$key = :$key", array_keys($data)));
        $data['id'] = $id;

        $stmt = $this->connection->prepare("UPDATE cities SET $setClause WHERE id = :id");
        return $stmt->execute($data);
    }

    public function delete(int $id): bool
    {
        if( !$this->checkId($id)) {
            throw new RecordNotFoundException();
        }

        $stmt = $this->connection->prepare("DELETE FROM cities WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    protected function validate(array $data): void
    {
        $diff = array_diff(array_keys($data), static::ALLOWED_COLUMNS);
        if ($diff) {
            throw new UnknownColumnException("Unknown column(s): ". implode(",", $diff));
        }
    }

    protected function checkId(int $id): bool
    {
        $stmt = $this->connection->prepare("SELECT COUNT(*) FROM cities where id = :id");
        $stmt->execute([':id' => $id]);

        if(!$stmt->fetchColumn() > 0) {
            return false;
        }

        return true;
    }
}