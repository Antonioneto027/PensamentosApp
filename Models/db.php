<?php


namespace Models\db;

use PDO;
use PDOException;

     $host = 'localhost';
     $db = 'thoughts_db';
     $user = 'root';
     $pass = '';
     $charset = 'utf8';
     $pdo;

 $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
 $opt = [
    \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
    \PDO::ATTR_EMULATE_PREPARES   => false,
];
   $pdo = new \PDO($dsn, $user, $pass, $opt);