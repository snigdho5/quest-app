<?php
include_once('../class.phpmailer.php');

$mail             = new PHPMailer(); // defaults to using php "mail()"
$mail->Host       = "10.50.4.20"; // SMTP server
//$mail->Host       = "mail.cesc.co.in"; // SMTP server
$mail->SMTPDebug  = 2;

$body_content="ljcll";
//$body             = $mail->getFile('mail_body.php');
$body             =$body_content; 

//$body             = eregi_replace("[\]",'',$body);

$mail->From       = "helpdesk@cesc.co.in";
$mail->FromName   = "IT Helpdesk";

$mail->Subject    = "IT HELPDESK";

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->MsgHTML($body);
$to="jayanta.ghosh@rp-sg.in";
$mail->AddAddress($to);

//$mail->AddAttachment("images/phpmailer.gif");             // attachment

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}

?>
