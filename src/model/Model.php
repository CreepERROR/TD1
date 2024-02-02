<?php

namespace iutnc\hellokant\model;

use iutnc\hellokant\query\Query;

abstract class Model
{

    public $values = [];

    protected $primary;

    public function __construct($table){
        $this->values = $table;
        if(isset($table['id'])){
            $this->primary = $table['id'];
        }
    }

    public function __get(string $name): mixed
    {
        if (method_exists($this, $name)) {
            return $this->$name();
        }

        return $this->values[$name] ?? null;
    }

    public function __set(string $name, mixed $value): void
    {
        $this->values[$name] = $value;
    }

    public function belongs_to(string $related, int $foreignKey): mixed
    {
        $relatedInstance = new $related([]);

        return $relatedInstance::find([[$relatedInstance->primary, '=', $foreignKey]]);
    }

    public function has_many(string $related, int $foreignKey): mixed
    {
        $relatedInstance = new $related([]);

        return $relatedInstance::find([[$foreignKey, '=', $this->primary]]);
    }
}