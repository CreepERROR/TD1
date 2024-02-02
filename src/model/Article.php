<?php

namespace iutnc\hellokant\model;

use iutnc\hellokant\query\Query;

require_once 'Model.php';

class Article extends Model
{
    const TABLE = 'article';

    protected $primary = 'id';

    public function __construct($table) {
        parent::__construct($table);
    }

    public static function all(): array
    {
        $q = Query::table('article')
            ->select(['*'])
            ->get();
        $articles = [];
        foreach($q as $article){
            $articles[] = new Article($article);
        }
        return $articles;
    }

    public static function find($conditions, $optional = null): array
    {
        $query = Query::table('article')
            ->select($optional ?? ['*']);

        foreach ($conditions as $condition) {
            $query->where($condition[0], $condition[1], $condition[2]);
        }

        $result = $query->get();

        if (!empty($result)) {
            $articles = [];
            foreach($result as $article){
                $articles[] = new Article($article);
            }
            return $articles;
        } else {
            return [];
        }
    }

    public static function first($cond,$opt=null): Article
    {
        $result = self::find($cond,$opt);
        if (!empty($result)) {
            return $result[0];
        } else {
            return new Article([]);
        }
    }

    public function categorie(): mixed
    {
        return $this->belongs_to(Categorie::class, $this->values['id_categ']);
    }
}