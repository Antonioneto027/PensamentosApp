<?php


namespace App\Controllers;

use App\Helpers\Helper;
use App\Controllers\ConnectDb;
use PDO;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '/opt/lampp/htdocs/thoughts/vendor/autoload.php';

class UserController
{

    private $conn;
    private $helper;

    private $confirmationCode;

    private $email;


 

    public function __construct(){
        $db = new ConnectDb();
        $this->conn = $db->getConnection();
        $this->helper = new Helper();
    }
    

     public function register() //Alterar o nome (esta função apenas dá inicio ao processo de registro)
    {
        $conn = $this->conn;
        $message = '';

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = $_POST["email"] ?? '';
            $this->email = $email;
            session_start();
            $_SESSION['email_hash'] = $this->helper->hashEmail($email);
            $password = $_POST['password_hash'] ?? '';
            $_SESSION['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
            $_SESSION['created_at']= date("Y-m-d H:i:s"); // cria a data atual

            // Verifica se e-mail já existe
            $checkEmailStmt = $conn->prepare("SELECT email_hash FROM users WHERE email_hash = ?");
            $checkEmailStmt->execute([$_SESSION['email_hash']]);

            if ($checkEmailStmt->fetch()) {
                $message = "Este e-mail já está sendo utilizado em uma conta";
                $toastClass = "#007bff"; // Azul
                $button = "<button> Clique aqui para voltar para a página de login </button>";
            } else {
                // Insere novo usuário
         

               $randomHash = $this->helper->confCode();
               session_start();
               $_SESSION['confirmation_code'] = $randomHash;
               $mail = new PHPMailer(exceptions: true);
               $mail->isSMTP();     


                 try {
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                    $mail->Host = 'live.smtp.mailtrap.io';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'smtp@mailtrap.io';
                    $mail->Password = 'f3e9f0655c410da4905e28bb6befeae4';
                  
                    $mail->Port = 2525;
                    $mail->CharSet = 'UTF-8';

                    $to = $this->email; 
                    $subject = "Pensamentos App - Código de Confirmação";
                    $body = "Seu código de confirmação é: {$randomHash}";

                    // Recipients
                    $mail->setFrom('no-reply@pensamentos.app.br', 'Pensamentos App');
                    $mail->addAddress($to);

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = $subject;
                    $mail->Body    = $body;
                    $mail->AltBody = strip_tags($body);

                    $mail->send();  

                    header("Location:/thoughts/confirm"); 
                    
                // echo 'Message has been sent';
                 } catch (Exception $e) {
                     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

                 }
                
                
        
            }
        }

        echo "<div style='background-color:$toastClass;color:white;padding:10px;'>$message</div>";
    }

    public function verifyConfirmationCode() { //Alterar o nome: esta função finaliza o processo de registro
       session_start();
       $confirmationCode = $_SESSION['confirmation_code']; //Código enviado por e-mail  
       $code = $_POST['code'] ?? ''; //Código inserido no formulário
       $email_hash = $_SESSION['email_hash']; //NULL
       $password_hash = $_SESSION['password_hash'];
       $created_at = $_SESSION['created_at']; 
       $toastClass = '';
       if ($confirmationCode === $code) {
         $stmt = $this->conn->prepare("INSERT INTO users (email_hash, password_hash, created_at) VALUES (?, ?, ?)");
         if ($stmt->execute([$email_hash, $password_hash, $created_at])) {
                        $message = "Account created successfully";
                        $toastClass = "#28a745"; // Verde
                        $button = '<a href="/thoughts/"><button>Click here to log in</button></a>';
                        echo "<div style='background-color:$toastClass;color:white;padding:10px;margin:10px 0;'>
                                $message<br>$button
                            </div>";
                        header("location: /thoughts/list");
                        session_destroy();
                        
                    } else {
                        $message = "Error: Não foi possível registrar, tente outro e-mail";
                        $toastClass = "#dc3545"; // Vermelho
                         header("location: /thoughts/");
                        session_destroy();
                    } 
       } else {
       echo "<div style='background-color:$toastClass;color:white;padding:10px;margin:10px 0;'>
                            Código Incorreto, tente novamente! <br>
                        </div>";
       }

        
        
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
                session_start();    
                $_SESSION['user_session'] = $email_hash;
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
        $_SESSION["user_session"] = null;
        session_abort();
        header("location: /thoughts/");
      
    }

}












 