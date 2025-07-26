<?php


namespace App\Controllers;

use Models\db\Database;
use PDO;
use PDOException;

class SubmitController
{

    private $conn;

    public function __construct(\PDO $pdo)
    {
        $this->conn = $pdo;
    }





    public function register() {
        
    }

    public function login() {

    }








   public function submit_thoughts($cause, $emotion, $intensity) {
    // Garante que o usuário está logado
    if (!isset($_SESSION['user_id'])) {
        throw new \Exception("Usuário não autenticado.");
    }

    $user_id = $_SESSION['user_id'];  
    $created_at = date('Y-m-d H:i:s');  

    $query = $this->conn->prepare("
        INSERT INTO emotions_log (user_id, cause, emotion, intensity, created_at)
        VALUES (:user_id, :cause, :emotion, :intensity, :created_at)
    ");

    $query->execute([
        ':user_id' => $user_id,
        ':cause' => $cause,
        ':emotion' => $emotion,
        ':intensity' => $intensity,
        ':created_at' => $created_at
    ]);
}

 public function list_thoughts() {

 }

 


}

?>