<?php

namespace Jklzz02\RestApi\gateways;


use Jklzz02\RestApi\Core\Database;
use Jklzz02\RestApi\interfaces\Gateway;
use PDO;

class CitiesTableGateway implements Gateway
{
    protected PDO $connection;
    protected const array columns = ['name', 'lat', 'lon', 'population', 'country'];

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

    public function findAllByName(string $name): array
    {
        $stmt = $this->connection->prepare("SELECT * FROM cities WHERE name = :name COLLATE NOCASE");
        $stmt->execute([':name' => $name]);
        return $stmt->fetchAll() ?: [];
    }

    public function findAllByCountry(string $country) :array
    {
        $stmt = $this->connection->prepare("SELECT * FROM cities WHERE country = :country COLLATE NOCASE");
        $stmt->execute([':country' => $country]);
        return $stmt->fetchAll() ?: [];
    }

    public function findAll(array $conditions = []): array
    {
        $query = "SELECT * FROM cities";
        $params = [];

        if (!empty($conditions)) {
            $clauses = [];
            foreach ($conditions as $key => $value) {
                $clauses[] = "$key = :$key";
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

        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_map(fn($key) => ":$key", array_keys($data)));

        $stmt = $this->connection->prepare("INSERT INTO cities ($columns) VALUES ($placeholders)");
        return $stmt->execute($data);
    }

    public function update(int $id, array $data): bool
    {
        $this->validate($data);
        if(!$this->checkId($id)) return false;

        $setClause = implode(', ', array_map(fn($key) => "$key = :$key", array_keys($data)));
        $data['id'] = $id;

        $stmt = $this->connection->prepare("UPDATE cities SET $setClause WHERE id = :id");
        return $stmt->execute($data);
    }

    public function delete(int $id): bool
    {
        if(!$this->checkId($id)) return false;
        $stmt = $this->connection->prepare("DELETE FROM cities WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    protected function validate(array $data): void
    {
        $diff = array_diff(array_keys($data), static::columns);
        if ($diff) {
            throw new \InvalidArgumentException("Unknown column(s): ". implode(",", $diff));
        }
    }

    protected function checkId(int $id): bool
    {
        $stmnt = $this->connection->prepare("SELECT COUNT(*) FROM cities where id = :id");
        $stmnt->execute([':id' => $id]);
        return $stmnt->fetchColumn() > 0;
    }
}
