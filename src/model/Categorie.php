<?php

namespace iutnc\hellokant\model;

use iutnc\hellokant\query\Query;

require_once 'Model.php';

class Categorie extends Model
{
    const TABLE = 'categorie';

    protected $primary = 'id';

    public function __construct($table) {
        parent::__construct($table);
    }

    public function articles(): array
    {
        return $this->has_many(Article::class, $this->values['id']);
    }

    public static function all(): array
    {
        $q = Query::table('categorie')
            ->select(['*'])
            ->get();
        $categories = [];
        foreach($q as $categorie){
            $categories[] = new Categorie($categorie);
        }
        return $categories;
    }

    public static function find($conditions, $optional = null): array
    {
        $query = Query::table('categorie')
            ->select($optional ?? ['*']);

        foreach ($conditions as $condition) {
            $query->where($condition[0], $condition[1], $condition[2]);
        }

        $result = $query->get();

        if (!empty($result)) {
            $categories = [];
            foreach($result as $categorie){
                $categories[] = new categorie($categorie);
            }
            return $categories;
        } else {
            return [];
        }
    }

    public static function first($cond,$opt=null): Categorie
    {
        $result = self::find($cond,$opt);
        if (!empty($result)) {
            return $result[0];
        } else {
            return new Categorie([]);
        }
    }
}