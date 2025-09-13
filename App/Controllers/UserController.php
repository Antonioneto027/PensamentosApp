<?php


namespace App\Controllers;
use App\Helpers\Helper;
use App\Controllers\ConnectDb;
use PDO;

class UserController
{

    private $conn;
    private $helper;

    public function __construct(){
        $db = new ConnectDb();
        $this->conn = $db->getConnection();
        $this->helper = new Helper();
    }
    

     public function register()
    {
        $conn = $this->conn;
        $message = '';
        $toastClass = '';

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = $_POST["email"] ?? '';
            $email_hash = $this->helper->hashEmail($email);
            $password = $_POST['password_hash'] ?? '';
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $created_at = date("Y-m-d H:i:s"); // cria a data atual

            // Verifica se e-mail já existe
            $checkEmailStmt = $conn->prepare("SELECT email_hash FROM users WHERE email_hash = ?");
            $checkEmailStmt->execute([$email_hash]);

            if ($checkEmailStmt->fetch()) {
                $message = "Este e-mail já está sendo utilizado em uma conta";
                $toastClass = "#007bff"; // Azul
                $button = "<button> Clique aqui para voltar para a página de login </button>";
            } else {
                // Insere novo usuário
                $stmt = $conn->prepare("INSERT INTO users (email_hash, password_hash, created_at) VALUES (?, ?, ?)");

                if ($stmt->execute([$email_hash, $password_hash, $created_at])) {
                    $message = "Account created successfully";
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
            $email_hash = $this->helper->hashEmail($email);
            $password = $_POST['password_hash'];

            $stmt = $conn->prepare("SELECT email_hash, password_hash FROM users WHERE email_hash = ?");
            $stmt->execute([$email_hash]);
            $fetch = $stmt->fetch();

            if ($fetch && password_verify($password, $fetch['password_hash'])) {
                header("location: /thoughts/list");
                exit;
            } else {
                echo "Login inválido";
            }
    }


  /*  public function getUserName() {
        $conn = $this->conn;

        $email = $_POST["email"];

        $stmt = $conn->prepare("SELECT username FROM users WHERE email = ?");
        $stmt-> execute([$email]);
        
        $return = $stmt->fetch(mode: PDO::FETCH_ASSOC);
        
        if ($return) {
           session_start();
           $_SESSION['username'] = $return["username"];
           $_SESSION["hash"] =  hash('sha256', $return['username']); //Criar um código hash para que o usuário não consiga acessar o sistema via link
        } else {
            return "Usuário não encontrado"; //Remover
        }
          
    }
*/

    public function logout() {
        $this->conn = null;
      //  $_SESSION["username"] = null;
        session_abort();
        header("location: /thoughts/");
      
    }

}












 