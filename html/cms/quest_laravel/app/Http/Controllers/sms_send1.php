<?php
function send_sms_medical($mobile_no = '', $sms_msg = '') {
    $arr = array();
    if (empty($mobile_no) || empty($sms_msg)) return $arr;

    $mobile_no = urlencode($mobile_no);
    $sms_msg = urlencode($sms_msg);

    $url = "http://www.cesc.co.in/send_url_api_sms.php?sms_msg=" . $sms_msg . "&mobile_no=" . $mobile_no . "&sender=MedicalIns";
    //echo $url . '<br>';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // To return the transfer as a string of the return value of curl_exec() instead of outputting it out directly
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $data = curl_exec($ch);
    curl_close($ch);

}

?>
