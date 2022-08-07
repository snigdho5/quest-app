<?php
header('Access-Control-Allow-Origin: *');

$category = filter_input(INPUT_POST, "category", FILTER_SANITIZE_STRING);

$isok ='Y';
if ($isok == 'Y') {
     $helpdsk_serever = 'https://questmall.in/cms/quest_laravel/public/';
	$post_url = $helpdsk_serever . 'issueType/'.$category;
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
