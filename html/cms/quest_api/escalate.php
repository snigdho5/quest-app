<?php

require_once 'dbCon.php';


try {

    $dbcon = new dbCon();
    $con = $dbcon->getConnection();


    $sql = "SELECT a.docket_no,a.subject,b.dept_name,c.issue_desc,a.email,a.mobile,TIMEDIFF(NOW(),a.comp_datetime) time_gap,c.escalation1_time,c.escalation1_email_id,c.escalation1_email_cc,                     c.escalation2_time,c.escalation2_email_id,c.escalation2_email_cc
            FROM retailer_complaint a,retailer_dept_master b,retailer_issue_master c
            WHERE a.category=b.dept_id AND a.issue_type=c.issue_id AND a.status IN ('1','4') ORDER BY c.escalation1_email_id,c.issue_desc";

    $stmt = $con->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $docket_no  = $row['docket_no'];
        $subject    = $row['subject'];
        $dept_name  = $row['dept_name'];
        $issue_desc = $row['issue_desc'];
        $email      = $row['email'];
        $mobile     = $row['mobile'];
        $time_gap   = $row['time_gap'];
        $escalation1_time = $row['escalation1_time'];
        $escalation1_email_id = $row['escalation1_email_id'];
        $escalation1_email_cc = $row['escalation1_email_cc'];
        $escalation2_time = $row['escalation2_time'];
        $escalation2_email_id = $row['escalation2_email_id'];
        $escalation2_email_cc = $row['escalation2_email_cc'];
        
    }

} catch (Exception $ex) {

    $data["status"] = "N";
    $data["err_msg"] = $ex;
}

?>





