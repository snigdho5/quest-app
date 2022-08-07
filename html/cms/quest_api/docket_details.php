<?php
header('Access-Control-Allow-Origin: *');

$docket = filter_input(INPUT_POST, "docket", FILTER_SANITIZE_STRING);

$isok ='Y';
if ($isok == 'Y') {
      $helpdsk_serever = 'https://questmall.in/cms/quest_laravel/public/';
  //  $helpdsk_serever = 'http://webtest/gendesk/public/';
    //$helpdsk_serever='http://10.50.81.45:81/helpdesk/public/';
    //$post_url = $helpdsk_serever . 'generateDocket/' . $user_id . '/' . urlencode($prob_desc) . '/' . $for_dept . '/' . $comp_type . '/' . $sub_prob . '/' . $prob_status . '/' . $mobile . '/' . $EpNo . '/' . $mode . '/' . $nodal . '/' . urlencode($other_loc) . '/' . $ven_id;
	$post_url = $helpdsk_serever . 'docketDetails/'.$docket;
//echo $post_url;
$arr['post_url'] = $post_url;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $post_url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 4);
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
