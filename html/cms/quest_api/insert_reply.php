<?php
header('Access-Control-Allow-Origin: *');

/*header('Access-Control-Allow-Origin: *');
header('Expires: Sat, 1 Jan 2005 00:00:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');
//include_once '../Mycescappsclass/Mycescappdataclass.php';
*/
$docket = filter_input(INPUT_POST, "docket", FILTER_SANITIZE_STRING);
$reply = filter_input(INPUT_POST, "reply", FILTER_SANITIZE_STRING);
$feedback_type = filter_input(INPUT_POST, "feedback_type", FILTER_SANITIZE_STRING);
/*$category = filter_input(INPUT_POST, "category", FILTER_SANITIZE_STRING);
$subject = filter_input(INPUT_POST, "subject", FILTER_SANITIZE_STRING);
//$location = filter_input(INPUT_POST, "location", FILTER_SANITIZE_STRING);
$mobile = filter_input(INPUT_POST, "mobile", FILTER_SANITIZE_STRING);
//$intercom = filter_input(INPUT_POST, "intercom", FILTER_SANITIZE_STRING);
$category_desc = filter_input(INPUT_POST, "category_desc", FILTER_SANITIZE_STRING);
$user =  filter_input(INPUT_POST, "user", FILTER_SANITIZE_STRING);
$staff_email =  filter_input(INPUT_POST, "staff_email", FILTER_SANITIZE_STRING);*/
$arr = Array();

$isok = 'Y';
//$arr['emp_code'] = $emp_code;
$arr['status'] = 'Error';

$isok ='Y';
if ($isok == 'Y') {
     $helpdsk_serever = 'https://questmall.in/cms/quest_laravel/public/';
    // $helpdsk_serever = 'http://webtest/gendesk/public/';
    //$helpdsk_serever='http://10.50.81.45:81/helpdesk/public/';
    //$post_url = $helpdsk_serever . 'generateDocket/' . $user_id . '/' . urlencode($prob_desc) . '/' . $for_dept . '/' . $comp_type . '/' . $sub_prob . '/' . $prob_status . '/' . $mobile . '/' . $EpNo . '/' . $mode . '/' . $nodal . '/' . urlencode($other_loc) . '/' . $ven_id;
//	$post_url = $helpdsk_serever . 'insertReply/' . $docket . '/' .$reply . '/'.$category. '/'.$subject. '/'.$location. '/'. $mobile. '/'. $intercom. '/'.$category_desc.'/'.$user.'/'.$staff_email;
	//$post_url = $helpdsk_serever . 'insertReply/' . $docket . '/' .$reply . '/'.$category. '/'.urlencode($subject). '/'. $mobile. '/'.urlencode($category_desc).'/'.$user.'/'.$staff_email;
	$post_url = $helpdsk_serever . 'insertReply/' . $docket . '/' .urlencode($reply). '/' . $feedback_type;
//echo $post_url;
$arr['post_url'] = $post_url;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $post_url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 300);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: close'));
    $curl_result = curl_exec($ch);
	if (curl_error($ch)) {
   $arr['curl_error']= curl_error($ch);
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
