<?php 

namespace App\Controllers;
use App\Controllers\ConnectDb;
use PDOException;

class ThoughtsController {

    private $conn; 

    public function __construct() {
        $db = new ConnectDb();
        $this->conn = $db->getConnection();
    }

    public function saveThoughts() {
        $conn = $this->conn;

        try {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //   $user_id = $_POST["id"]; // Coloque o índice correto aqui
                $cause = $_POST["cause"]; // Coloque o índice correto aqui
                $emotion = $_POST["emotion"]; // Coloque o índice correto aqui
                $intensity = $_POST["intensity"]; // Coloque o índice correto aqui
                $thoughts = $_POST["thought"]; // Coloque o índice correto aqui
                $created_at = date("Y-m-d H:i:s");

                $stmt1 = $conn->prepare("INSERT INTO emotions_log (cause, emotion, intensity, created_at) VALUES (?, ?, ?, ?)");
                $stmt1->bindValue(1, $cause);
                $stmt1->bindValue(2, $emotion);
                $stmt1->bindValue(3, $intensity);
                $stmt1->bindValue(4, $created_at);
                $stmt1->execute();

                $stmt2 = $conn->prepare("INSERT INTO thoughts_log (thought, created_at) VALUES (?, ?)");
                $stmt2->bindValue(1, $thoughts);
                $stmt2->bindValue(2, $created_at);
                $stmt2->execute();
            }
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }
}

?>