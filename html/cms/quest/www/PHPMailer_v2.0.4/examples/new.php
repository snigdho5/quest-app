<?php

include_once('../class.phpmailer.php');

$mail             = new PHPMailer(); // defaults to using php "mail()"
//$body             = $mail->getFile('mail_body.php');
$msg="mail";
$body             =$msg;

$mail->IsSMTP(); // telling the class to use SMTP
$mail->Host       = "10.50.2.20"; // SMTP server
$mail->SMTPDebug  = 2;

//$body             = eregi_replace("[\]",'',$body);

$mail->From       = "helpdesk@cesc.co.in";
$mail->FromName   = "IT Helpdesk";
$subject="Mail Checking";
$mail->Subject    =$subject;

//$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->MsgHTML($body);
$to="jayanta.ghosh@cesc.co.in";
$mail->AddAddress($to);
//$mail->AddAttachment("images/phpmailer.gif");             // attachment

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  //echo "Message sent!";
}
$mail ->ClearAddresses();
?>
