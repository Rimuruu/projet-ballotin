<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';
include '../model/authentificateGmail.php';



function sendMail($mailAdress,$message){

    global $user;
    global $password;
    //Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $user;                     //SMTP username
    $mail->Password   = $password;                               //SMTP password
    $mail->SMTPSecure = 'ssl';         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 465;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('noreplay@gmail.com', 'NoReply');   //Add a recipient
    $mail->addAddress($mailAdress);               //Name is optional
    $mail->addReplyTo('noreplay@gmail.com', 'NoReply');


    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Mot de passe';
    $mail->Body    = $message;
    $mail->AltBody = $message;

    $mail->send();
    return 'Message has been sent';
} catch (Exception $e) {
    return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}


}