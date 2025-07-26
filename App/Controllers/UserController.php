<?php


namespace App\Controllers;
use App\Controllers\ConnectDb;

class UserController
{

    private $conn;

    public function __construct(){
        $db = new ConnectDb();
        $this->conn = $db->getConnection();
    }
    

     public function register()
    {
        $conn = $this->conn;
        $message = '';
        $toastClass = '';

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password_hash'] ?? '';
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $created_at = date("Y-m-d H:i:s"); // cria a data atual

            // Verifica se e-mail já existe
            $checkEmailStmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
            $checkEmailStmt->execute([$email]);

            if ($checkEmailStmt->fetch()) {
                $message = "Email ID already exists";
                $toastClass = "#007bff"; // Azul
                $button = "<button> Click here to come back to login page </button>";
            } else {
                // Insere novo usuário
                $stmt = $conn->prepare("INSERT INTO users (name, email, password_hash, created_at) VALUES (?, ?, ?, ?)");

                if ($stmt->execute([$name, $email, $password_hash, $created_at])) {
                    $  $message = "Account created successfully";
                    $toastClass = "#28a745"; // Verde
                    $button = '<a href="/thoughts/"><button>Click here to log in</button></a>';
                    echo "<div style='background-color:$toastClass;color:white;padding:10px;margin:10px 0;'>
                            $message<br>$button
                        </div>";
    return;
                } else {
                    $message = "Error: Não foi possível registrar";
                    $toastClass = "#dc3545"; // Vermelho
                }
            }
        }

        echo "<div style='background-color:$toastClass;color:white;padding:10px;'>$message</div>";
    }

    public function login() {
            $conn = $this->conn;

                
            $email = $_POST['email'];
            $password = $_POST['password_hash'];

            $stmt = $conn->prepare("SELECT id, password_hash FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $fetch = $stmt->fetch();

            if ($fetch && password_verify($password, $fetch['password_hash'])) {
                header("location: /thoughts/list");
                exit;
            } else {
                echo "Login inválido";
            }
    }




}













 