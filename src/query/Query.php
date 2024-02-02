<?php

namespace iutnc\hellokant\query;

use iutnc\hellokant\connexion\ConnectionFactory;
use PDO;

class Query
{
    private $sqltable;
    private $fields = '*';
    private $where = null;
    private $args = [];
    private $sql = '';

    public static function table(string $table): Query
    {
        $query = new Query;
        $query->sqltable = $table;
        return $query;
    }

    public function select(array $fields): Query
    {
        $this->fields = implode(',', $fields);
        return $this;
    }

    public function where(string $col, string $op, mixed $val): Query
    {
        if ($this->where === null) {
            $this->where = $col . $op . '?';
        } else {
            $this->where .= ' AND ' . $col . $op . '?';
        }
        $this->args[] = $val;
        return $this;
    }

    public function get(): array
    {
        $this->sql = 'select ' . $this->fields .
            ' from ' . $this->sqltable;
        if($this->where !== null) {
            $this->sql .= ' where ' . $this->where;
        }
        $stmt = ConnectionFactory::makeConnection()->prepare($this->sql);
        $stmt->execute($this->args);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert(array $data): int
    {
        $this->sql = 'insert into ' . $this->sqltable . ' (';
        $this->sql .= implode(',', array_keys($data));
        $this->sql .= ') values (';
        $this->sql .= implode(',', array_fill(0, count($data), '?'));
        $this->sql .= ')';
        $pdo= ConnectionFactory::makeConnection();
        $stmt = ConnectionFactory::makeConnection()->prepare($this->sql);
        $stmt->execute(array_values($data));
        return (int)$pdo->lastInsertId($this->sqltable);
    }

    public function delete(): bool
    {
        $this->sql = 'delete from ' . $this->sqltable;
        if($this->where !== null) {
            $this->sql .= ' where ' . $this->where;
        }
        $stmt = ConnectionFactory::makeConnection()->prepare($this->sql);
        return $stmt->execute($this->args);
    }

    public function all(): array
    {
        $this->sql = 'select ' . $this->fields .
            ' from ' . $this->sqltable;
        $stmt = ConnectionFactory::makeConnection()->prepare($this->sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}