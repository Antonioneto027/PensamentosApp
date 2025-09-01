<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use Helpers\MailConfig;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
 
//Load Composer's autoloader (created by composer, not included with PHPMailer)
require 'vendor/autoload.php';
 
//Create an instance; passing `true` enables exceptions
 



class Mail extends PHPMailer {

    private $mail;
    private $config;

    public function __construct() { 


        $this->mail = new PHPMailer(true);
        $this->config = new MailConfig() ;

    }

    public function sendMail () {


        try {
            //Server settings
            $this->config;
            //Recipients
            $this->mail->setFrom('from@example.com', 'Mailer');
            $this->mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
            $this->mail->addAddress('ellen@example.com');               //Name is optional
            $this->mail->addReplyTo('info@example.com', 'Information');
            $this->mail->addCC('cc@example.com');   
            $this->mail->addBCC('bcc@example.com');

            //Attachments
            $this->mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            $this->mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $this->mail->isHTML(true);                                  //Set email format to HTML
            $this->mail->Subject = 'Here is the subject';
            $this->mail->Body    = 'This is the HTML message body <b>in bold!</b>';
            $this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $this->mail->send();
            echo 'Message has been sent';

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }

    }
    
}
 