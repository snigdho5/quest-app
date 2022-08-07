<?php
header('Access-Control-Allow-Origin: *');
$email = $_GET["email"];
$password = $_GET["password"];
$url = "http://cescintranet/helpdesk/PHPMailer_v2.0.4/examples/test_gmail_auth.php?email=".$email."&password=".$password;
//echo $url;
// create a new cURL resource
$ch = curl_init();

// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);

// grab URL and pass it to the browser
curl_exec($ch);

// close cURL resource, and free up system resources
curl_close($ch);
?>
