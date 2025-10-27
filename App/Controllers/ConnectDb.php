<?php

namespace App\Controllers;

use PDO;
use PDOException;

class ConnectDb 
{
    private $conn;

    public function __construct()
    {   
        
        require '/opt/lampp/htdocs/thoughts/config.php';
        $db_path = $dsn_path;
        $charset = 'utf8mb4';
        $dsn = "sqlite:$db_path";

        try {
            $pdo = new PDO($dsn); [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ];
            $this->conn = $pdo;
        } catch (PDOException $e) {
            die('Erro ao conectar: ' . $e->getMessage());
        }
    }

    public function getConnection(): PDO
    {
        return $this->conn;
    }
}
