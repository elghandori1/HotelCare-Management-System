<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if(isset($_POST['send'])){
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'deltapaplo@gmail.com';
        $mail->Password = 'oudz rsec zvhp pjhp';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom("deltapaplo@gmail.com");
        $mail->addAddress("mohamedelghandori4@gmail.com");
        $mail->isHTML(true);
        $mail->Subject = $_POST['description'];
        $mail->Body = "http://localhost/projectHotel/page_connexion.php";

        $mail->send();
        echo 'Message has been sent successfully';
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }
}
?>
