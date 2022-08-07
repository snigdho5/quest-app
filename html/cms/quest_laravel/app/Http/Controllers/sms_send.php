<?php
# Sending SMS through URL
/**
*
* @param type $mobile_no
* @param type $sms_msg
*/

function send_sms($mobile_no = '', $sms_msg = '') {
    $arr = array();
    if (empty($mobile_no) || empty($sms_msg)) return $arr;

    $mobile_no = urlencode($mobile_no);
    $sms_msg = urlencode($sms_msg);

    //$mobile_no = '9432082543';   // -- Mob. Manish
    //$mobile_no = '9748002836';   // -- Mob. - Jaynta

   // $url = "http://cesc.co.in/send_sms_test.php?sms_msg=" . $sms_msg . "&mobile_no=" . $mobile_no;
     $url = "http://cesc.co.in/send_url_api_sms.php?sms_msg=" . $sms_msg . "&mobile_no=" . $mobile_no . "&sender=IT_HELPDESK";
    //echo $url . '<br>';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // To return the transfer as a string of the return value of curl_exec() instead of outputting it out directly
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $data = curl_exec($ch);
    curl_close($ch);

  }
?>
