  <?php /*
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
 
//Load Composer's autoloader (created by composer, not included with PHPMailer)
require '../vendor/autoload.php';
 
//Create an instance; passing `true` enables exceptions
 



class Mail extends PHPMailer {

    private $mail;
    private $config;

    public function __construct() { 


        $this->mail = new PHPMailer(true);
 
    }

    public function sendMail () {


        try {
            //Server settings
                  
            $this->mail->isSMTP();
            $this->mail->Host = 'live.smtp.mailtrap.io';
            $this->mail->SMTPAuth = true;
            $this->mail->Port = 587;
            $this->mail->Username = 'smtp@mailtrap.io';
            $this->mail->Password = '11023826cfcc9d2974a972b47b91bfbe';
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
            $this->mail->CharSet = 'UTF-8';
            
            //Recipients
            $this->mail->setFrom('no-reply@pensamentos.app.br', 'Pensamentos App');
            $this->mail->addAddress('web.everybody822@passinbox.com', 'Antonio');     //Add a recipient
            //$this->mail->addAddress('ellen@example.com');               //Name is optional
            //$this->mail->addReplyTo('info@example.com', 'Information');
            //$this->mail->addCC('cc@example.com');   
            //$this->mail->addBCC('bcc@example.com');

            //Attachments
            //$this->mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$this->mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $this->mail->isHTML(true);                                  //Set email format to HTML
            $this->mail->Subject = 'E-mail teste';
            $this->mail->Body    = 'Olá!';
            $this->mail->AltBody = 'Olá';

            $this->mail->send();

            echo 'Message has been sent';

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }

    }
    
}

    $mail = new Mail();
    $mail->sendMail(); 
*/
?>





 