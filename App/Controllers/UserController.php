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
     /*     $db = new ConnectDb();
        $this->conn = $db->getConnection();   */
        $this->helper = new Helper();
    }
   

     public function register() //Alterar o nome (esta função apenas dá inicio ao processo de registro)
    {       session_start();
            $_SESSION['db'] = "globals";
            require_once("/opt/lampp/htdocs/thoughts/config.php");
            $conn = new ConnectDb(); //BUG: Quando inicia-se a nova conexão, a variável $db fica null.
            $db = $conn->getConnection();


        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = $_POST["email"] ?? '';
            $this->email = $email;
            session_start();
            $_SESSION['email_hash'] = $this->helper->hashEmail($email);
            $password = $_POST['password_hash'] ?? '';
            $_SESSION['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
            $_SESSION['created_at']= date("Y-m-d H:i:s"); // cria a data atual

            // Verifica se e-mail já existe
            $checkEmailStmt = $db->prepare("SELECT email_hash FROM users WHERE email_hash = ?");

            $checkEmailStmt->execute([$_SESSION['email_hash']]);

            if ($checkEmailStmt->fetch()) {
                
                $msg = '
                <article class="container" style="max-width: 400px; margin: 2rem auto;">
                    <div class="bg-primary" style="padding: 1rem; border-radius: 8px; color: #0734ffff; text-align: center;">
                        <span>Este e-mail já está sendo utilizado em outra conta</span>
                        <br><br>
                        <a href="/thoughts/public/register" role="button" class="secondary"><button>Tentar com outro e-mail    </button></a>
                    </div>
                </article>
                ';

                echo $msg;
            } else {
                // Insere novo usuário
         

               $randomHash = $this->helper->confCode();
               session_start();
               $_SESSION['confirmation_code'] = $randomHash;
               $mail = new PHPMailer(exceptions: true);
               $mail->isSMTP();     


                 try {
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                    $mail->Host = $_ENV['MAIL_HOST'];
                    $mail->SMTPAuth = true;
                    $mail->Username = $_ENV['MAIL_USER'];
                    $mail->Password = $_ENV['MAIL_KEY'];
                  
                    $mail->Port = 2525;
                    $mail->CharSet = 'UTF-8';

                    $to = $this->email; 
                    $subject = "Pensamentos App - Código de Confirmação";
                    $body = "Seu código de confirmação é: {$randomHash}";
                    $mailAdress = $_ENV['MAIL_SEND'];
                    $mailName = $_ENV['MAIL_NAME'];

                    // Recipients
                    $mail->setFrom($mailAdress, $mailName);
                    $mail->addAddress($to);

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = $subject;
                    $mail->Body    = $body;
                    $mail->AltBody = strip_tags($body);

                    $mail->send();  

                    header("Location:/thoughts/public/confirm"); 
                    
                // echo 'Message has been sent';
                 } catch (Exception $e) {
                     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

                 }
                
                
        
            }
        }

    //    echo "<div style='background-color:$toastClass;color:white;padding:10px;'>$message</div>";
    }

    public function verifyConfirmationCode() {  
        session_start();
       $confirmationCode = $_SESSION['confirmation_code'];  
       $code = $_POST['code'] ?? '';  
       $email_hash = $_SESSION['email_hash'];  
       $password_hash = $_SESSION['password_hash'];
       $created_at = $_SESSION['created_at']; 
       $last_login = date("Y-m-d H:i:s");
       $toastClass = '';
        
       if ($confirmationCode === $code) {
        $_SESSION['db'] = "globals";
            require_once("/opt/lampp/htdocs/thoughts/config.php");
            $conn = new ConnectDb(); //BUG: Quando inicia-se a nova conexão, a variável $db fica null.
            $db = $conn->getConnection();
            $stmt = $db->prepare("INSERT INTO users (email_hash, password_hash, created_at, last_login) VALUES (?, ?, ?, ?)");
         if ($stmt->execute([$email_hash, $password_hash, $created_at, $last_login])) {
                        $_SESSION['user_session'] = $email_hash;
                        require('../config.php');
                        $_SESSION['db'] = $email_hash;
                        $conn = new ConnectDb();
                        $db = $conn->getConnection();
                     $db->exec("
                                        CREATE TABLE IF NOT EXISTS emotions_log (
                                            id INTEGER PRIMARY KEY AUTOINCREMENT,
                                            cause VARCHAR(255) NOT NULL,
                                            emotion VARCHAR(255) NOT NULL,
                                            intensity INT NOT NULL,
                                            thought1 VARCHAR(255) NOT NULL,
                                            thought2 VARCHAR(255) NOT NULL,
                                            thought3 VARCHAR(255) NOT NULL,
                                            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                                        );
                                    ");
                     /*   $message = "Account created successfully";
                        $toastClass = "#28a745";  
                        $button = '<a href="/thoughts/public"><button>Click here to log in</button></a>';
                        echo "<div style='background-color:$toastClass;color:white;padding:10px;margin:10px 0;'>
                                $message<br>$button
                            </div>"; */
                        
                        header("location: /thoughts/public/list");
                        
                        
                    } else {
                        $message = "Error: Não foi possível registrar, tente outro e-mail";
                        $toastClass = "#dc3545";  
                         header("location: /thoughts/public");
                        session_destroy();
                    } 
       } else {
       echo "<div style='background-color:$toastClass;color:white;padding:10px;margin:10px 0;'>
                            Código Incorreto, tente novamente! <br>
                        </div>";
       }

        
        
    }

    public function login() {
         

            session_start();   
            $email = $_POST['email'];
            $email_hash = $this->helper->hashEmail($email);
            $password = $_POST['password_hash'];
            
            require_once("/opt/lampp/htdocs/thoughts/config.php");
            $_SESSION["db"] = $_ENV["DB_NAME"];
            $conn = new ConnectDb();
            $db = $conn->getConnection();

            $stmt = $db->prepare("SELECT email_hash, password_hash FROM users WHERE email_hash = ?");
         
            $stmt->execute([$email_hash]);
            $fetch = $stmt->fetch();

            if ($fetch && password_verify($password, $fetch['password_hash'])) {
                  
                $_SESSION['user_session'] = $email_hash; //Não identifica a variável.
                $stmt = $db->prepare("UPDATE users SET last_login = datetime('now') WHERE email_hash = ?");
                $stmt->execute([$email_hash]);
                require_once("../config.php");
                $_SESSION["db"] = $email_hash;
                header("location: /thoughts/public/list");
                exit;
            } else {
                   $msg = '
                <article class="container" style="max-width: 400px; margin: 2rem auto;">
                    <div class="bg-primary" style="padding: 1rem; border-radius: 8px; color: #0734ffff; text-align: center;">
                        <span>Login inválido!</span>
                        <br><br>
                        <a href="/thoughts/public/" role="button" class="secondary"><button> Tente novamente </button></a>
                    </div>
                </article>
                ';

                echo $msg;
                session_destroy();
            }
    }



    public function logout() {
        $this->conn = null;
        $_SESSION["user_session"] = null;
        session_abort();
        header("location: /thoughts/public");
      
    }

}











