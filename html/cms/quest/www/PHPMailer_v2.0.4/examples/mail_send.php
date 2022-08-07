<?php

//include_once('../class.phpmailer.php');

$mail             = new PHPMailer(); // defaults to using php "mail()"
//$body             = $mail->getFile('mail_body.php');
$body             =$msg;

$mail->IsSMTP(); // telling the class to use SMTP
//$mail->Host       = "10.50.4.20"; // SMTP server
$mail->Host       = "mail.cesc.co.in"; // SMTP server

//$body             = eregi_replace("[\]",'',$body);

$mail->From       = "helpdesk@cesc.co.in";
$mail->FromName   = "IT Helpdesk";

$mail->Subject    =$subject;

//$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->MsgHTML($body);
$mail->AddAddress($to);
//$mail->AddAttachment("images/phpmailer.gif");             // attachment

if(!$mail->Send()) {
//  echo "Mailer Error: " . $mail->ErrorInfo;
   $a=1;
} else {
  //echo "Message sent!";
}

$mail ->ClearAddresses();
?>
