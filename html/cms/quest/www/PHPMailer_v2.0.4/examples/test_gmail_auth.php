<?php
header('Access-Control-Allow-Origin: *');
include_once('class.phpmailer.php');
include_once('../class.smtp.php');

$mail             = new PHPMailer(); // defaults to using php "mail()"
//$body             = $mail->getFile('mail_body.php');
//$body             =$msg;
$email = $_GET["email"];
$domain = explode("@",$email);
$password =$_GET["password"];

$arr = Array();

if($domain[1] == 'rp-sg.in')
{
$mail->IsSMTP(); // enable SMTP
//$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = true; // authentication enabled
$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
$mail->Host = "smtp.gmail.com";
$mail->Port = 465; // or 587
$mail->IsHTML(true);
$mail->Username = $email;
$mail->Password = $password;

if($mail->smtpConnect()){
    $mail->smtpClose();
  // echo "Connected";
   $arr['status'] = 'Success';
   $arr['email'] = $email;
    echo json_encode($arr);
}
else{
    //echo "Connection Failed";
	$arr['status'] = 'Failure';
        $arr['domain'] = $domain[1];
        $arr['email'] = $email;
        $arr['password'] = $password;
    echo json_encode($arr);
}
}
else{
    //echo "Connection Failed";
        $arr['status'] = 'Failure';
        $arr['domain1'] = $domain[1];
    echo json_encode($arr);
}

$mail ->ClearAddresses();*/
?>
