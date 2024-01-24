<?php
    use PHPMailer\PHPMailer\PHPMailer;
    require_once './vendor/autoload.php';
    include './config/smtp.php';

    $smtpInfoNew =  new smtpInfo();
    $mail = new PHPMailer();

    $mail->isSMTP();
    $mail->Host = $smtpInfoNew->host;
    $mail->Username = $smtpInfoNew->username;
    $mail->Password = $smtpInfoNew->password;
    $mail->SMTPAuth = $smtpInfoNew->auth;
    $mail->Port = $smtpInfoNew->port;
    $mail->SMTPSecure = $smtpInfoNew->secure;
    
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    // $mail->Port = 587;
    // $mail->isSMTP();
    // $mail->Host = 'smtp.gmail.com';
    // $mail->SMTPAuth = false;
    // $mail->SMTPAutoTLS = false; 
    // $mail->Port = 25; 

    $mail->setFrom($smtpInfoNew->fromEmail, $smtpInfoNew->fromName);
    $mail->addAddress($smtpInfoNew->toEmail, $smtpInfoNew->toName);
    $mail->Subject = 'esse e o assunto';

    $mail->isHTML(TRUE);
    $mail->Body = '<html>Hi there, we are happy to <br>confirm your booking.</br> Please check the document in the attachment.</html>';
    $mail->AltBody = 'Hi there, we are happy to confirm your booking. Please check the document in the attachment.';

    // add attachment 
    // just add the '/path/to/file.pdf'
    // $attachmentPath = './confirmations/yourbooking.pdf';
    // if (file_exists($attachmentPath)) {
    //     $mail->addAttachment($attachmentPath, 'yourbooking.pdf');
    // }

    if(!$mail->send()){
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent';
    }
    $mail->smtpClose();

?>