<?php
header('Access-Control-Allow-Origin: *');

/*header('Access-Control-Allow-Origin: *');
header('Expires: Sat, 1 Jan 2005 00:00:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');
//include_once '../Mycescappsclass/Mycescappdataclass.php';
*/
$user_id = filter_input(INPUT_POST, "user_id", FILTER_SANITIZE_EMAIL);
$subject = filter_input(INPUT_POST, "subject", FILTER_SANITIZE_STRING);
//$desc = filter_input(INPUT_POST, "desc", FILTER_SANITIZE_STRING);
//$location = filter_input(INPUT_POST, "location", FILTER_SANITIZE_STRING);
$issue_type = filter_input(INPUT_POST, "issue_type", FILTER_SANITIZE_STRING);
$mobile = filter_input(INPUT_POST, "mobile", FILTER_SANITIZE_STRING);
//$intercom = filter_input(INPUT_POST, "intercom", FILTER_SANITIZE_STRING);
//$priority = filter_input(INPUT_POST, "priority", FILTER_SANITIZE_STRING);
$category = filter_input(INPUT_POST, "category", FILTER_SANITIZE_STRING);
//$myFile = $_FILES['file']['name'];



//$data = filter_input(INPUT_POST, "data", FILTER_SANITIZE_STRING);
//echo "data ".$data;
/*if($category == '100')
    $other_category = filter_input(INPUT_POST, "other_category", FILTER_SANITIZE_STRING);
else
    $other_category = 'NA';*/
if($mobile == '')
   $mobile = '-';
/*if($intercom == '')
   $intercom = '-';*/

//$mode = filter_input(INPUT_POST, "mode", FILTER_SANITIZE_STRING);
$mode = "web";
$arr = Array();
$arr['user_id'] = $user_id;
$arr['subject'] = $subject;
//$arr['desc'] = $desc;
//$arr['priority'] = $priority;
$arr['category'] = $category;
//$arr['mode'] = $mode;
$arr['issue_type'] = $issue_type;
$arr['mobile'] = $mobile;
//$arr['intercom'] = $intercom;

// This function will return a random
// string of specified length
function random_strings($length_of_string)
{

    // String of all alphanumeric character
    $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    // Shufle the $str_result and returns substring
    // of specified length
    return substr(str_shuffle($str_result),
                       0, $length_of_string);
}

//**************File Upload **************************************

if(isset($_FILES['file'])){
      $errors= array();
      //$file_name = $_FILES['file']['name'];
      $file_extension = explode(".",$_FILES['file']['name']);
      $file_name = random_strings(20).".".$file_extension[1];
      $file_size =$_FILES['file']['size'];
      $file_tmp =$_FILES['file']['tmp_name'];
      $file_type=$_FILES['file']['type'];
      //$file_ext=strtolower(end(explode('.',$_FILES['file']['name'])));
      $values = explode('.',$file_name);
      $file_ext=strtolower(array_pop($values));

      $extensions= array("jpeg","jpg","png","pdf","doc","docx");

      if(in_array($file_ext,$extensions)=== false){
         $errors[]="Attached file extension not allowed, please choose a JPEG, PNG, PDF or DOC file.";
      }

      if($file_size > 2097152){
         $errors[]='File size must be with in 2 MB';
      }

      if(empty($errors)==true){
         move_uploaded_file($file_tmp,"attach/".$file_name);
         //echo "Success";
        // echo $file_name."-".$file_sie."-".$file_type;
      }else{
         //print_r($errors);
      }
   }
   //************File Upload*****************************************


$emp_code = $user_id;
if(count($errors) == 1)
    $isok ='N';
else
    $isok = 'Y';

if ($isok == 'Y') {
   if($file_name == '')
       $file_name = "NA";
   # $helpdsk_serever = 'http://webtest/gendesk/public/';
     $helpdsk_serever = 'https://questmall.in/cms/quest_laravel/public/';
    //$helpdsk_serever='http://10.50.81.45:81/helpdesk/public/';
    //$post_url = $helpdsk_serever . 'generateDocket/' . $user_id . '/' . urlencode($prob_desc) . '/' . $for_dept . '/' . $comp_type . '/' . $sub_prob . '/' . $prob_status . '/' . $mobile . '/' . $EpNo . '/' . $mode . '/' . $nodal . '/' . urlencode($other_loc) . '/' . $ven_id;
    $post_url = $helpdsk_serever . 'newTicket/' . $user_id . '/' .$subject.'/' .$category .'/'.$issue_type.'/'.$mobile.'/'.$file_name;
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
    //print_r($arr);
    //$arr['status'] = 'Success';
    //echo json_encode($arr);
} else {
    $arr['status'] = 'Failure';
    $arr['err_msg'] = $errors[0];
    echo json_encode($arr);
}
?>
