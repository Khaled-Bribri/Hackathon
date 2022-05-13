<?php

namespace App\Service;

use App\Controller\AbstractController;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer extends AbstractController
{
    public function sendMail(string $user, string $message)
    {

        try {
            //Server settings
            $phpmailer = new PHPMailer();
            $phpmailer->isSMTP();
            $phpmailer->Host = 'smtp.mailtrap.io';
            $phpmailer->SMTPAuth = true;
            $phpmailer->Port = 2525;
            $phpmailer->Username = '96feba9f0e4600';
            $phpmailer->Password = '94d9bb8a1fd71a';

            //Recipients
            $phpmailer->setFrom('monassistant@monfrigo.fr', 'Mon Assistant');
            $phpmailer->addAddress($user, 'Joe User');     //Add a recipient
            // $mail->addAddress('ellen@example.com');               //Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $phpmailer->isHTML(true);                                  //Set email format to HTML
            $phpmailer->Subject = 'Des produits vous attendent dans votre frigo !';
            $phpmailer->Body    = $message;
            $phpmailer->AltBody = 'This is the body in plain text for non-HTML mail clients';

            var_dump($phpmailer->send());
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$phpmailer->ErrorInfo}";
        }
    }
}
