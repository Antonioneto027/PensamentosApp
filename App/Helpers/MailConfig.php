<?php 
namespace Helpers;

use PHPMailer\PHPMailer\DSNConfigurator;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;

 

class MailConfig {

    private $mail;
    
    function __construct() {

       $phpmailer = new PHPMailer();
        $phpmailer->isSMTP();
        $phpmailer->Host = 'live.smtp.mailtrap.io';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 587;
        $phpmailer->Username = '3400642d24c0fbe566c128a410d2615f';
        $phpmailer->Password = '1756717975';
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $this->mail->Port       = 465;                                    //TC

    }
 
    
}

     

















