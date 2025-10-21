<?php 

namespace App\Controllers;
use App\Controllers\ConnectDb;
use PDOException;

class ThoughtsController {

    private $conn; 

<<<<<<< HEAD
  /*  public function __construct() {
        $db = new ConnectDb();
        $this->conn = $db->getConnection();
    } */

    public function saveThoughts() {
        

        session_start();
        $_SESSION["db"] = $_SESSION['user_session'];
        require("../config.php");
        $conn = new ConnectDb();
        $db = $conn->getConnection();
=======
    public function __construct() {
        $db = new ConnectDb();
        $this->conn = $db->getConnection();
    }

    public function saveThoughts() {
        $conn = $this->conn;
>>>>>>> origin/main

        try {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                session_start();
<<<<<<< HEAD
               
=======
                $user_id =  $_SESSION['user_session'];
>>>>>>> origin/main
                $cause = $_POST["cause"];  
                $emotion = $_POST["emotion"];  
                $intensity = $_POST["intensity"];  
                $thought1 = $_POST["thought1"] ?? "";  
                $thought2 = $_POST["thought2"] ?? "";
                $thought3 = $_POST["thought3"] ?? "";
                $created_at = date("Y-m-d H:i:s");

<<<<<<< HEAD
                $stmt1 = $db->prepare("INSERT INTO emotions_log (cause, emotion, intensity, thought1, thought2, thought3, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt1->bindValue(1, $cause);
                $stmt1->bindValue(2, $emotion);
                $stmt1->bindValue(3, $intensity);
                $stmt1->bindValue(4, $thought1);
                $stmt1->bindValue(5, $thought2);
                $stmt1->bindValue(6, $thought3);
                $stmt1->bindValue(7, $created_at);
=======
                $stmt1 = $conn->prepare("INSERT INTO emotions_log (user_id, cause, emotion, intensity, thought1, thought2, thought3, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt1->bindValue(1, $user_id);
                $stmt1->bindValue(2, $cause);
                $stmt1->bindValue(3, $emotion);
                $stmt1->bindValue(4, $intensity);
                $stmt1->bindValue(5, $thought1);
                $stmt1->bindValue(6, $thought2);
                $stmt1->bindValue(7, $thought3);
                $stmt1->bindValue(8, $created_at);
>>>>>>> origin/main
                $stmt1->execute();
                header("location: /thoughts/public/list");
             }
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }

    public function listThoughts() {
<<<<<<< HEAD
        
        session_start();
        $_SESSION['db'] = $_SESSION['user_session']; //Insere o hash de usuário para informar ao sistema qual o banco pertencente ao usuário.É no banco de usuário que estarão seus pensamentos.
        $user_id =  $_SESSION['user_session'];
               
        $conn = new ConnectDb(); //Utiliza a variaǘel privada para que não seja necessário se conectar com o banco todas as vezes, já que aqui o usuário já está logado.
        $db = $conn->getConnection();
       
        
        try {

        /*    $conn = new ConnectDb(); //Utiliza a variaǘel privada para que não seja necessário se conectar com o banco todas as vezes, já que aqui o usuário já está logado.
            $db = $conn->getConnection();
            $stmt = $db->prepare("SELECT * FROM emotions_log WHERE user_id = ? ORDER BY created_at DESC"); //Identificar problema do prepare.
            $stmt->bindValue(1, $user_id);
            $stmt->execute(); */
           $stmt = $db->prepare("SELECT * FROM emotions_log ORDER BY created_at DESC;");
           $stmt->execute();
             
           return $stmt;
=======
        $conn = $this->conn;
        session_start();
        $user_id =  $_SESSION['user_session'];
        try {
            $stmt1 = $conn->prepare("SELECT * FROM emotions_log WHERE user_id = ? ORDER BY created_at DESC");
            $stmt1->bindValue(1, $user_id);
            $stmt1->execute();
             
           return $stmt1;
>>>>>>> origin/main
         
        } catch (PDOException $e) {
            echo "Erro: ". $e->getMessage();
        } finally {
            $conn = null;
        }

    }


   public function deleteThoughts() {
<<<<<<< HEAD

    $conn = new ConnectDb();
    $db = $conn->getConnection();

=======
    $conn = $this->conn;
>>>>>>> origin/main
    session_start();

    try {
        if (!empty($_POST['ids'])) {
            $ids = $_POST['ids'];

<<<<<<< HEAD
            $placeholders = implode(',', array_fill(0, count($ids), '?')); 
            $stmt = $db->prepare("DELETE FROM emotions_log WHERE id IN ($placeholders)");
=======
            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            $stmt = $conn->prepare("DELETE FROM emotions_log WHERE id IN ($placeholders)");
>>>>>>> origin/main
            $stmt->execute($ids);

            // Redireciona após exclusão
            header('Location: /thoughts/public/list');
            exit;
        } else {
            // Nenhum checkbox selecionado
            header('Location: /thoughts/public/list');
            exit;
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    } finally {
        $conn = null;
    }
}

}  
 