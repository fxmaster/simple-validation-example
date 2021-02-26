<?php

declare(strict_types=1);

namespace App\Models\DB;

use PDO;

class QueryBuilder
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll(string $table): array
    {
        $sql = 'SELECT * FROM :table';
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'table' => $table,
        ]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOne(string $table, int $id): array
    {
        $sql = 'SELECT * FROM :table WHERE id = :id';
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'table' => $table,
            'id' => $id,
        ]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function create(string $table, array $data): bool
    {
        // some set of kostyls))
        $columns = implode(',', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));

        $sql = 'INSERT INTO :table (:columns) VALUES (:values)';
        $statement = $this->pdo->prepare($sql);

        return $statement->execute([
            'table' => $table,
            'columns' => $columns,
            'values' => $values,
        ]);
    }

    public function update(string $table, int $id, array $data): bool
    {
        $keys = array_keys($data);

        foreach ($keys as $key) {
            $columns .= $key . '=:' .$key . ',';
        }
        $keys = rtrim($columns,',');
        unset($columns);
        $sql = 'UPDATE :table set :keys WHERE id = :id';
        $statement = $this->pdo->prepare($sql);
        
        return $statement->execute([
            'table' => $table,
            'keys' => $keys,
            'id' => $id,
        ]);
    }

    public function delete(string $table, int $id): bool
    {
        $sql = 'DELETE FROM :table WHERE id = :id';
        $statement = $this->pdo->prepare($sql);
        
        return $statement->execute([
            'table' => $table,
            'id' => $id
        ]);
    }

    public function exist(string $table, string $column, $value): bool
    {
        $sql = 'SELECT * FROM :table WHERE :column = :value';
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'table' => $table,
            'column' => $column,
            'value' => $value,
        ]);

        return  $statement->fetch(PDO::FETCH_ASSOC) ? true : false;
    }
}