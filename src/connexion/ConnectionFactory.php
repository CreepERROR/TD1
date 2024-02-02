<?php


namespace iutnc\hellokant\connexion;

use PDO;

class ConnectionFactory
{

    static ?array $config = null;
    static ?PDO $pdo = null;

    static function makeConnection(): PDO
    {
        ConnectionFactory::$config = parse_ini_file('../conf/db.conf.ini');

        if (ConnectionFactory::$pdo == null) {
            ConnectionFactory::$pdo = new PDO(ConnectionFactory::$config['driver'] . ':host=' . ConnectionFactory::$config['host'] . '; 
        dbname=' . ConnectionFactory::$config['base'] . '; charset=utf8', ConnectionFactory::$config['user'], ConnectionFactory::$config['password']);
        }
        return ConnectionFactory::$pdo;
    }
}