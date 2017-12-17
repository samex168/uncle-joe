<?php
require_once('./_common/params.php');
require_once('./plugins/SwiftMailer/swift_required.php');

function sendmail($to, $subject, $message, $from, $fromName=''){
	$smtpHost = "smtp.bbmail.com.hk";
    $smtpUser = "";
    $smtpPassword = "";
    $smtpAuth = false;
    $smtpPort = 25;

    $subject = $subject;
 //   $email_from = "info@freecom.com";
    $email_from = $from;
    $from_name = "Uncle Joe";
    $email_content = $message;

    $email = $to;
    $name = "";

    if($smtpAuth)
    {
        $transport = Swift_SmtpTransport::newInstance($smtpHost, $smtpPort)->setUsername($smtpUser)->setPassword($smtpPassword);
    }else{
        $transport = Swift_SmtpTransport::newInstance($smtpHost, $smtpPort);
    }
    $mailer = Swift_Mailer::newInstance($transport);

    $message = Swift_Message::newInstance($subject)
        ->setFrom(array($email_from=>$from_name))
        ->setTo(array($email=>$name))
        ->setBody($email_content)
        ->setContentType("text/html")
        ;
    // Send the message
    $result = $mailer->send($message);

    return $result;
}
?>