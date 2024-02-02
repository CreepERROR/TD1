<?php

use iutnc\hellokant\connexion\ConnectionFactory;
use iutnc\hellokant\query\Query;
use iutnc\hellokant\model\Article;
use iutnc\hellokant\model\Categorie;

require_once 'connexion/ConnectionFactory.php';
require_once 'query/Query.php';
require_once 'model/Article.php';
require_once 'model/Categorie.php';

/*
$q = Query::table('article')
    ->select(['*'])
    ->where('nom', '=', 'Benjamin')
    ->get();
var_dump($q);

$i = Query::table('article')
    ->insert(['nom' => 'camion', 'descr' => 'camion en jouet', 'tarif' => 93.41,'id_categ' => 1]);

$d = Query::table('article')
    ->where('nom', '=', 'velo')
    ->delete();
*/

//FINDER
/*
$arti=Article::all();
var_dump($arti);

$arti=Article::find(1);
var_dump($arti);

$arti=Article::find([['id','=','64'],['nom','=','velo']],['nom']);
var_dump($arti);

$arti=Article::first([['id','=','64'],['nom','=','velo']],['nom']);
var_dump($arti);

$arti=Article::first([['id','=','64'],['nom','=','velo']]);
var_dump($arti->categorie());
*/

$categ=Categorie::first([['id','=','1']]);
var_dump($categ->articles());
