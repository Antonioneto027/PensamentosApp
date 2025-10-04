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
                session_start();
                $user_id =  $_SESSION['user_session'];
                $cause = $_POST["cause"];  
                $emotion = $_POST["emotion"];  
                $intensity = $_POST["intensity"];  
                $thought1 = $_POST["thought1"] ?? "";  
                $thought2 = $_POST["thought2"] ?? "";
                $thought3 = $_POST["thought3"] ?? "";
                $created_at = date("Y-m-d H:i:s");

                $stmt1 = $conn->prepare("INSERT INTO emotions_log (user_id, cause, emotion, intensity, thought1, thought2, thought3, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt1->bindValue(1, $user_id);
                $stmt1->bindValue(2, $cause);
                $stmt1->bindValue(3, $emotion);
                $stmt1->bindValue(4, $intensity);
                $stmt1->bindValue(5, $thought1);
                $stmt1->bindValue(6, $thought2);
                $stmt1->bindValue(7, $thought3);
                $stmt1->bindValue(8, $created_at);
                $stmt1->execute();
                header("location: /thoughts/list");
             }
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }

    public function listThoughts() {
        $conn = $this->conn;
        session_start();
        $user_id =  $_SESSION['user_session'];
        try {
            $stmt1 = $conn->prepare("SELECT * FROM emotions_log WHERE user_id = ? ORDER BY created_at DESC");
            $stmt1->bindValue(1, $user_id);
            $stmt1->execute();
             
           return $stmt1;
         
        } catch (PDOException $e) {
            echo "Erro: ". $e->getMessage();
        } finally {
            $conn = null;
        }

    }


   public function deleteThoughts() {
    $conn = $this->conn;
    session_start();

    try {
        if (!empty($_POST['ids'])) {
            $ids = $_POST['ids'];

            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            $stmt = $conn->prepare("DELETE FROM emotions_log WHERE id IN ($placeholders)");
            $stmt->execute($ids);

            // Redireciona após exclusão
            header('Location: /thoughts/list');
            exit;
        } else {
            // Nenhum checkbox selecionado
            header('Location: /thoughts/list');
            exit;
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    } finally {
        $conn = null;
    }
}

}  
 