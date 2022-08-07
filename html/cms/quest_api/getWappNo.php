<?php

header('Access-Control-Allow-Origin: *');

/* header('Access-Control-Allow-Origin: *');
  header('Expires: Sat, 1 Jan 2005 00:00:00 GMT');
  header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
  header('Cache-Control: no-cache, must-revalidate');
  header('Pragma: no-cache');
  //include_once '../Mycescappsclass/Mycescappdataclass.php';
 */
$issue_type = filter_input(INPUT_POST, "issue_type", FILTER_SANITIZE_STRING);
//$otp = filter_input(INPUT_POST, "otp", FILTER_SANITIZE_STRING);

$arr = Array();

$isok = 'Y';
//$arr['emp_code'] = $emp_code;
$arr['status'] = 'Error';

$isok = 'Y';
if ($isok == 'Y') {
    $helpdsk_serever = 'https://questmall.in/cms/quest_laravel/public/';
    $post_url = $helpdsk_serever . 'getWappNo/' . $issue_type;
//echo $post_url;
    $arr['post_url'] = $post_url;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $post_url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 100);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: close'));
    $curl_result = curl_exec($ch);
    if (curl_error($ch)) {
        $arr['curl_error'] = curl_error($ch);
    }
    curl_close($ch);
    echo $curl_result;
    //echo $arr;
    //$arr['curl_result'] =$curl_result;
    //$arr['status'] = 'Success';
    // echo json_encode($arr);
} else {
    $arr['status'] = 'Failure';
    echo json_encode($arr);
}
?>
