<?php
namespace App\Http\Controllers;
header('Access-Control-Allow-Origin: *');
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\ProblemDetails;
use App\Http\Resources\Task;
use App\Http\Resources\solution;
use App\Http\Resources\dept;
use App\Http\Resources\mainProblemType;
use App\Http\Resources\subproblemType;
use App\Http\Resources\vendorList;
use App\Http\Resources\locationName;
use App\Http\Resources\category;
use App\Http\Resources\issueType;
use App\Http\Resources\docketDetails;
use App\Http\Resources\solutionDetails;
use App\Http\Resources\docketAllocation;
use App\Http\Resources\docketAllocationPending;
use App\Http\Resources\userType;
use DB;
use Carbon\Carbon;
use App\Http\Controllers\MailController;

//include("sms_send.php");


class TaskController extends Controller
{
    public function getCategory($dept_type)
    {
        $category = DB::table('retailer_dept_master')
       ->where('retailer_dept_master.dept_type', '=', $dept_type )
        ->orderBy('retailer_dept_master.dept_id')
        ->get();
        // Return the collection of dept list
        return category::collection($category);
       // return $category;

    }

    public function issueType($category)
    {
        $issueType = DB::table('retailer_issue_master')
        ->where('retailer_issue_master.dept_id', '=', $category )
        ->orderBy('retailer_issue_master.issue_id')
        ->get();
        // Return the collection of dept list
        return issueType::collection($issueType);
       // return $category;

    }
    public function getCategoryEscalate()
    {
        $category = DB::table('lkup_category')
        ->whereNotIn('category_id', [4,100])->get(); 
       // Return the collection of dept list
        return category::collection($category);
       // return $category;

    }
    
    public function getLocation()
    {
        $location = DB::table('lkup_location')
        ->orderBy('lkup_location.location_id')
        ->get();
        // Return the collection of dept list
        return locationName::collection($location);
       // return $category;

    }
   public function newTicket($user_id,$subject,$category,$issue_type,$mobile,$file_name)
   {
     try{
      $docket = DB::select(DB::raw('SELECT MAX(docket_no)+1 docket FROM retailer_complaint WHERE SUBSTRING(docket_no,1,2)=RIGHT(YEAR(CURDATE()),2) AND  SUBSTRING(docket_no,3,2)=MONTH(CURDATE())'));
      if(isset($docket[0]->docket))
      {
          $final_docket = $docket[0]->docket;

      }
      else
      {
          $new_docket = DB::select(DB::raw('SELECT CONCAT(RPAD(CONCAT(SUBSTRING(YEAR(CURDATE()),3,2),LPAD(MONTH(CURDATE()),2,0)),7,0),1) docket'));
          $final_docket = $new_docket[0]->docket;
      }

     DB::table('retailer_complaint')->insert(
                            ['docket_no' => $final_docket, 'subject' => $subject, 'category' => $category, 'email' => $user_id,'comp_datetime'=>Carbon::now()->toDateTimeString(),'issue_type' => $issue_type, 'mobile' => $mobile, 'status' => '1','attachment' => $file_name]
                        );
      //---------Auto Allocation Logic -----------------
     /* $staff_id = DB::table('lkup_staff')
      ->where('lkup_staff.category', 'like', '%' .$category . '%')->get();

      $prev_count=0;
      $i = 0;
      foreach($staff_id as $staff)
      {
       //  emp_code=$staff->emp_code;
         $emp_email = $staff->emp_email;
         $alloc_count = DB::table('docket_allocation')
         ->where('docket_allocation.staff_id', '=', $emp_email)
         ->whereNull('solution_time')
         ->count();
        
         if($i == 0)
         {
	   $prev_count = $alloc_count;
           $staff_id = $emp_email;
         }
         else
          {
            if($alloc_count < $prev_count)
            { 
               $prev_count = $alloc_count;
               $staff_id = $emp_email;
            }
          }
        $i++; 
      }
      if(!isset($staff_id))
          $staff_id = $emp_email;
      */
   /*   $staff_id = DB::table('retailer_issue_master')
      ->where('retailer_issue_master.issue_id', '=',$issue_type)
      //->where('lkup_staff.support_type', '=', '1')
      ->get();
      foreach($staff_id as $staff)
      {
       //  emp_code=$staff->emp_code;
         $staff_id = $staff->email_id;
      }*/

       $staff_id = DB::table('retailer_issue_master')
       ->join('whatsapp_number', 'retailer_issue_master.email_id', '=', 'whatsapp_number.email')
      ->where('retailer_issue_master.issue_id', '=',$issue_type)
      //->where('lkup_staff.support_type', '=', '1')
      ->select('retailer_issue_master.email_id','whatsapp_number.mobile')
      ->get();
      foreach($staff_id as $staff)
      {
       //  emp_code=$staff->emp_code;
         $staff_id = $staff->email_id;
         $wa_mobile = $staff->mobile;
      }

          
      DB::table('docket_allocation')->insert( ['docket_no' => $final_docket, 'staff_id' => $staff_id, 'alloc_time' => Carbon::now()->toDateTimeString()] );
      /*$staff_name = DB::table('lkup_staff')->select('emp_code','emp_name','emp_mobile')->where('emp_email' ,'=', $staff_id)->get();
      foreach($staff_name as $staffname)
      {
         $code = $staffname->emp_code;
         $name = $staffname->emp_name;
         $mobile = $staffname->emp_mobile;
      }
      */
       $category_name = DB::table('retailer_issue_master')
      ->where('retailer_issue_master.issue_id','=', $issue_type)->get();
      foreach($category_name as $cat)
      {
        $cat_name = $cat->issue_desc;
      }

      $whatsapp_text = $subject;
      $msg = "Quest Helpdesk - New Docket no. -".$final_docket."- User -".$user_id."- Category -".$cat_name."- Subject -".$subject;
     /* $msg = "<html><body><table align=center border=1><tr bgcolor=#ffdd22><td>Generation IT Helpdesk - New Docket</td></tr></table><br/>";
      $msg .="<table><tr align=center bgcolor=#22wwee><td>Docket No.</td><td>".$final_docket."</td></tr>";
      $msg .="<tr align=center bgcolor=#22wwee><td>User</td><td>".$user_id."</td></tr>";
      $msg .="<tr align=center bgcolor=#22wwee><td>Category</td><td>".$cat_name."</td></tr>";
      $msg .="<tr align=center bgcolor=#22wwee><td>Subject</td><td>".$subject."</td></tr></table></body></html>";*/
      $subject = "Quest Helpdesk - New Docket: ".$final_docket;
     // send_sms($mobile,$msg);

     $controller = new MailController();
     $controller->html_email($msg,$subject,$staff_id,$issue_type);
  //   $controller->html_email($msg,$subject,"jayanta.ghosh@rpsg.in");

     //************Whatsapp Notification **************************

      $this->whatsapp_notification($wa_mobile,$final_docket,$user_id,$cat_name,$whatsapp_text);
     
      $response["status"] = "Success";
      $response["docket_no"] = $final_docket;
      $response["staff_id"] = $staff_id;
//      $response["image_code"] = $code.".jpg";
//      $response["staff_name"] = $name;
      $response["staff_mobile"] = $mobile;
      // echoing JSON response
      echo json_encode($response);

      }
      catch (\Exception $e) {
       //  echo $e->getMessage();
       $response["status"] = $e->getMessage();
       $response["docket_no"] = "NA";
       // echoing JSON response
       echo json_encode($response);
      }



   }


   // Function to generate OTP
public function generateNumericOTP($n) {

    // Take a generator string which consist of
    // all numeric digits
    $generator = "1357902468";

    // Iterate for n-times and pick a single character
    // from generator and append it to $result

    // Login for generating a random character from generator
    //     ---generate a random number
    //     ---take modulus of same with length of generator (say i)
    //     ---append the character at place (i) from generator to result

    $result = "";

    for ($i = 1; $i <= $n; $i++) {
        $result .= substr($generator, (rand()%(strlen($generator))), 1);
    }

    // Return result
    return $result;
}
// Function to send SMS
public function send_sms($mobile_no = '', $sms_msg= '') {
    $arr = array();
    if (empty($mobile_no) || empty($sms_msg)) return $arr;

    $mobile_no = urlencode($mobile_no);
    $sms_msg = urlencode($sms_msg);

    //$mobile_no = '9432082543';   // -- Mob. Manish
    //$mobile_no = '9748002836';   // -- Mob. - Jaynta

   // $url = "http://cesc.co.in/send_sms_test.php?sms_msg=" . $sms_msg . "&mobile_no=" . $mobile_no;
     $url = "http://cesc.co.in/send_url_api_sms.php?sms_msg=" . $sms_msg . "&mobile_no=" . $mobile_no . "&sender=MedicalIns";
    //echo $url . '<br>';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // To return the transfer as a string of the return value of curl_exec() instead of outputting it out directly
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $data = curl_exec($ch);
    curl_close($ch);

  }

public function send_sms_medical($mobile_no = '', $sms_msg = '') {
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

public function whatsapp_notification($mobile,$dkt,$user,$cat,$subject) {

//    $mobile = "919748002836";
    $user = urlencode($user);
    $cat = urlencode($cat); 
    $subject = urlencode($subject);

    $url = "http://bulksms.nkinfo.in/pushwhatsapp.php?username=QSTWAPP&api_password=ac54b5cr1gopk2dip&sender=918100753975&priority=21&name=NewTicket&to=".$mobile."&value1=".$dkt."&value2=".$user."&value3=".$cat."&value4=".$subject;
  //  $url = "http://www.cesc.co.in/send_url_api_sms.php?sms_msg=" . $sms_msg . "&mobile_no=" . $mobile_no . "&sender=MedicalIns";
    //echo $url . '<br>';

    /*$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // To return the transfer as a string of the return value of curl_exec() instead of outputting it out directly
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $data = curl_exec($ch);
    curl_close($ch);*/

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 300);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: close'));

    $data = curl_exec($ch);
    curl_close($ch);

}

public function whatsapp_otp($mobile,$otp) {

//    $mobile = "919748002836";

    $url = "http://bulksms.nkinfo.in/pushwhatsapp.php?username=QSTWAPP&api_password=ac54b5cr1gopk2dip&sender=918100753975&priority=21&name=OTP&to=".$mobile."&value1=".$otp;  
//  $url = "http://www.cesc.co.in/send_url_api_sms.php?sms_msg=" . $sms_msg . "&mobile_no=" . $mobile_no . "&sender=MedicalIns";
    //echo $url . '<br>';

    /*$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // To return the transfer as a string of the return value of curl_exec() instead of outputting it out directly
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $data = curl_exec($ch);
    curl_close($ch);*/

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 300);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: close'));

    $data = curl_exec($ch);
    curl_close($ch);

}


   public function generateOTP($email,$flag)
   {
       $n=6;
       $otp = $this->generateNumericOTP($n);

       $prev_otp_delete = DB::table('otp')->where('email', '=', $email)->delete();

       $otp_status = DB::table('otp')->insert(['email' => $email, 'otp' => $otp,'otp_datetime'=> Carbon::now()->toDateTimeString()]);

        if($otp_status == '1')
        {
          $response["status"] = "Success";
          $msg = "Your Quest Service Desk OTP: ".$otp;
          $subject = "Quest Service Desk - OTP";

          if($flag == 1)
          {
             /*$sms_msg='Bank details for Medical Insurance premium:Bank Name: YES Bank Limited - Branch name: CMS NATIONAL OPERATING CENTRE - Account Type: Current Account - Account Name: CESC Limited - Account No.: CESCEM'.$otp.' - IFSC Code: YESB0CMSNOC';
             $mobile_no = $email;
             //include("/var/www/html/quest_laravel/app/Http/Controllers/sms_send.php");
             $this->send_sms_medical($mobile_no,$sms_msg);*/
             $this->whatsapp_otp($email,$otp);
          }
          if($flag == 2)
          {
          	$controller = new MailController();
          //	$email="jayanta.ghosh@rpsg.in";
          	$controller->otp_email($msg,$subject,$email);
          }

        }
     else
          $response["status"] = "Failure";
      // echoing JSON response
      echo json_encode($response);

 }
   public function checkOTP($email,$otp)
   {
       $auth_count = DB::table('otp')
         ->where('otp.email', '=', $email)
         ->where('otp.otp', '=', $otp)
         ->count();

        if($auth_count == '1')
         $response["status"] = "Success";
        else
          $response["status"] = "Failure";
      // echoing JSON response
      echo json_encode($response);


   }

 public function checkRetailer($email)
   {
       $auth_count = DB::table('retailer_master')
         ->where('retailer_master.retailer_email', '=', $email)
         ->orWhere('retailer_master.retailer_mobile', '=', $email)
         ->count();

        if($auth_count == '1')
         $response["status"] = "Success";
        else
          $response["status"] = "Failure";
      // echoing JSON response
      echo json_encode($response);


   }
  
   public function checkAdmin($email)
   {
       $auth_count = DB::table('admin_master')
         ->where('admin_master.admin_email', '=', $email)
         ->orWhere('admin_master.admin_mobile', '=', $email)
         ->count();

        if($auth_count == '1')
         $response["status"] = "Success";
        else
          $response["status"] = "Failure";
      // echoing JSON response
      echo json_encode($response);


   }

   public function getWappNo($issue_type)
   {

       $wa_no = DB::table('whatsapp_number')
            ->join('retailer_issue_master', 'whatsapp_number.email', '=', 'retailer_issue_master.email_id')
            ->where('retailer_issue_master.issue_id', '=', $issue_type)
            ->select('whatsapp_number.mobile')
            ->get();

        if($wa_no == '1')
        {
         $response["status"] = "Success";
        }
        else
          $response["status"] = "Failure";
      // echoing JSON response
      echo json_encode($response);


   }
 
   public function insertFeedback($docket, $feedback)
   {
      $insert_status = DB::table('retailer_complaint')
      ->where('docket_no', $docket)
      ->update(['status' => $feedback]);
      // Return a collection of dockets
     //  return insertFeedback::collection($insert_status);
        if($insert_status == '1')
          $response["status"] = "Success";
        else
          $response["status"] = "Failure";
      // echoing JSON response
      echo json_encode($response);


   }
 
/*   public function insertReply($docket, $reply, $category, $sub, $mobile, $category_desc, $user,$staff_email)
   {
      if($category != 0)
         $reply = 'Escalated-'.$reply;

        $insert_reply = DB::table('docket_solution')->insert(['docket_no' => $docket,'solution' => $reply, 'solution_time' => Carbon::now()->toDateTimeString(),'escalation_type' => $category]);

         if($category != 0)
         {
              $controller = new MailController();
              $subject = "Generation IT Helpdesk Escalation";
          //    $msg="<html><table><tr><td>Docket No.</td><td>".$docket."</td></tr><tr><td>Subject</td><td>".$subject."</td></tr></table></html>";
              $msg="Docket No.:".$docket." -Subject: ".$sub." -Location:".$location." -Mobile: ".$mobile." -Intercom: ".$intercom." -Category: ".$category_desc." -User: ".$user."- Escalation: ".$reply;
              $controller->html_email_escalate($msg,$subject,$category,$staff_email);
         }
 
        if($category == 0)
        {
      		$update_status = DB::table('complaint')
      		->where('docket_no', $docket)
      		->update(['status' => '3' ]);
        }
        else
        {
                $update_status = DB::table('complaint')
                ->where('docket_no', $docket)
                ->update(['status' => '5' ]);

        }

      $staff_id = DB::table('lkup_staff')
     // ->where('lkup_staff.emp_location', '=',$location)
      ->where('lkup_staff.support_type', '=', '2')
      ->where('lkup_staff.category', 'like', '%' .$category . '%') 
      ->get();
      foreach($staff_id as $staff)
      {
       //  emp_code=$staff->emp_code;
         $staff_email_id = $staff->emp_email;
         $staff_mobile = $staff->emp_mobile;
      }

        
      // Return a collection of dockets
     //  return insertFeedback::collection($insert_status);
        if($insert_reply == '1' ||  $update_status == '1')
          $response["status"] = "Success";
        else
          $response["status"] = "Failure";
      // echoing JSON response
      echo json_encode($response);

   }
*/
 public function insertReply($docket, $reply, $feedback_type)
   {
       $reply = urldecode($reply);

       $insert_reply = DB::table('docket_solution')->insert(['docket_no' => $docket,'solution' => $reply, 'solution_time' => Carbon::now()->toDateTimeString()]);

         $update_status = DB::table('retailer_complaint')
         ->where('docket_no', $docket)
         ->update(['status' => $feedback_type ]);

      // Return a collection of dockets
     //  return insertFeedback::collection($insert_status);
        if($insert_reply == '1'){
          $response["status"] = "Success";
          //------------Fetching User ID and mail notification--------------------
          $userDetails = DB::table('retailer_complaint')
          ->where('retailer_complaint.docket_no', '=', $docket)
          ->first();

          $complainant_email =  $userDetails->email;
          $subject='Quest Service Desk - Update Docket No.: '.$docket;
          $controller = new MailController();
          $controller->html_email_user($reply,$subject,$complainant_email);

        }
        else{
          $response["status"] = "Failure";
        }
      // echoing JSON response
      echo json_encode($response);


   }

   public function docketAllocation($userid)
   {
       $docket_allocation = DB::table('docket_allocation')
       // ->leftJoin('lkup_priority', 'complaint.priority', '=', 'lkup_priority.priority_id')
        ->leftJoin('retailer_complaint', 'retailer_complaint.docket_no', '=', 'docket_allocation.docket_no')
       // ->leftJoin('lkup_location', 'complaint.location', '=', 'lkup_location.location_id')
        ->where('docket_allocation.staff_id', '=', $userid )
       // ->whereNull('solution')
        ->orderBy('retailer_complaint.docket_no','desc')
        //->take(15)
        ->get();
        // Return a collection of dockets
        return docketAllocation::collection($docket_allocation);
        //return $problemStatus;


   }

   public function docketAllocationPending()
   {
       $docket_allocation_pending = DB::table('complaint')
       // ->leftJoin('lkup_priority', 'complaint.priority', '=', 'lkup_priority.priority_id')
        ->where('complaint.status', '!=', '2' )
        ->orderBy('complaint.comp_datetime','desc')
        //->take(15)
        ->get();
        // Return a collection of dockets
        return docketAllocationPending::collection($docket_allocation_pending);
        //return $problemStatus;


   }

    //
    public function problemDetails($userid)
    {

        $problemStatus = DB::table('retailer_complaint')
       // ->leftJoin('lkup_priority', 'complaint.priority', '=', 'lkup_priority.priority_id')
        ->leftJoin('retailer_issue_master', 'retailer_complaint.issue_type', '=', 'retailer_issue_master.issue_id')
        ->where('retailer_complaint.email', '=', $userid)
        ->orderBy('retailer_complaint.comp_datetime','desc')
        //->take(15)
        ->get();

 
        // Return a collection of dockets
        return Task::collection($problemStatus);
        //return $problemStatus;
    }

    public function docketDetails($docket)
    {
        $docketStatus = DB::table('retailer_complaint')
        ->leftJoin('docket_allocation', 'retailer_complaint.docket_no', '=', 'docket_allocation.docket_no')
        ->leftJoin('retailer_issue_master', 'retailer_complaint.issue_type', '=', 'retailer_issue_master.issue_id')
        ->leftJoin('lkup_status', 'retailer_complaint.status', '=', 'lkup_status.status_id')
       // ->leftJoin('lkup_staff', 'docket_allocation.staff_id', '=', 'lkup_staff.emp_email')
       // ->leftJoin('lkup_location', 'complaint.location', '=', 'lkup_location.location_id')
        ->where('retailer_complaint.docket_no', '=', $docket)
        ->get();
        return docketDetails::collection($docketStatus);
    }

    public function complainantName($email_mob)
    {
      $users = DB::table('retailer_master')
                    ->where('retailer_email', '=', $email_mob)
                    ->orWhere('retailer_mobile', '=', $email_mob)
                    ->get(); 
      
     foreach($users as $user)
      {
        $user_name = $user->name;
      }
      echo $user_name; 
    }
 
    public function fetchEmail($mob)
    {
      $users = DB::table('retailer_master')
                    ->Where('retailer_mobile', '=', $mob)
                    ->get();

     foreach($users as $user)
      {
        $user_name = $user->retailer_email;
      }
      echo $user_name;
    }


    public function userType($userid)
    {

       $userType_count =  DB::table('lkup_staff')
       ->where('emp_email', '=', $userid)
       ->count();
       
      if($userType_count == '1')
      {
        /* $userType_details = DB::table('lkup_staff')
         ->where('emp_email', '=', $userid)
         ->get();
         
         return userType::collection($userType_details);
       //return($userType_details);*/
        $response["emp_type"]="1";
    
        return(json_encode($response));
      }
      else
      {
      
      /* $str='{"data":[{"userType":"4"}]}';
       $str1='[{"type":"4"}]';
       $data = Array();
       $data["type"] = "0";
        return (json_encode($data));
        $data = [];
        $data[] = [
        'type' => '0'
    ];
       return userType::collection($data);
       return($data);
       return($str);*/
       $response["emp_type"]="0";
       return(json_encode($response));
      }
    }
 
    public function solutionDetails($docket)
    {
       $solutionDetails = DB::table('docket_solution')
       ->leftJoin('docket_allocation', 'docket_solution.docket_no', '=', 'docket_allocation.docket_no')
       ->leftJoin('retailer_complaint', 'retailer_complaint.docket_no', '=', 'docket_solution.docket_no')
       ->where('docket_solution.docket_no', '=', $docket)
       ->get();
       return solutionDetails::collection($solutionDetails);
    }




/*
    public function solutionDetails($dkt)
    {

        $solutionDetails = $users = DB::table('solution')
        ->where('docket_no', '=', $dkt)
        ->orderBy('solution.solution_time','desc')
        ->take(1)
        ->get();

 
        // Return the latest solution status against a particular docket
        return solution::collection($solutionDetails);
    }
*/
    public function deptList()
    {
        $deptList = DB::table('dept')
        ->get();
        // Return the collection of dept list
        return dept::collection($deptList);

    }

    public function mainProblemType()
    {
        $mainProblemType = DB::table('main_problem_types')
        ->get();
        // Return the collection of dept list
        return mainProblemType::collection( $mainProblemType);

    }

    public function subProblemType($prob_type)
    {
        $subproblemType = DB::table('subproblem_types')
        ->where('mainproblem_code', '=',$prob_type)
        ->orderBy('subproblem_description')
        ->get();
        // Return the collection of dept list
        return subproblemType::collection($subproblemType);

    }

    public function vendorList($dept)
    {
        $vendorList = DB::table('vendor')
        ->distinct()
        ->select('vendor_id','vendor_name')
        ->where('dept_id', '=',$dept)
        ->orderBy('vendor_name')
        ->get();
        // Return the collection of dept list
        return vendorList::collection($vendorList);

    }
    
    
    public function locationName()
    {
        $locationName = DB::table('nodal_center')
        ->orderBy('nodal_center_name')
        ->get();
        // Return the collection of dept list
        return locationName::collection($locationName);

    }
 
    public function generateDocket($user_id,$prob_desc,$for_dept,$comp_type,$sub_prob_type,$prob_status_code,$mobile,$epabx,$mode,$nodal_center_id,$other_loc,$ven_id)
    {

        // array for JSON response
        $response = array();

        $result = DB::transaction(function () use ($user_id,$prob_desc,$for_dept,$comp_type,$sub_prob_type,$prob_status_code,$mobile,$epabx,$mode,$nodal_center_id,$other_loc,$ven_id) {
           try
           {
                $prob_desc = urldecode($prob_desc);
                $other_loc = urldecode($other_loc);
                $controller = new MailController();

                $docket = DB::select(DB::raw('SELECT MAX(RIGHT(docket_no,7))+1 docket FROM problem_details WHERE SUBSTRING(docket_no,2,2)=RIGHT(YEAR(CURDATE()),2) AND  SUBSTRING(docket_no,4,2)=MONTH(CURDATE()) and left(docket_no,1)= :type'),array(
                    'type' => $comp_type,)) ;
                if(isset($docket[0]->docket))
                {
                    $final_docket = DB::select(DB::raw('SELECT CONCAT(:comp_type,LPAD(:docket,7,0)) docket'),array(
                        'comp_type' => $comp_type,'docket'=> $docket[0]->docket)) ;
                
                }  
                else
                {
                    $final_docket = DB::select(DB::raw('SELECT CONCAT(:comp_type,RPAD(CONCAT(SUBSTRING(YEAR(CURDATE()),3,2),LPAD(MONTH(CURDATE()),2,0)),6,0),1) docket'),array('comp_type' => $comp_type)); 
                }
            
                if(isset($final_docket))
                {
                    if($nodal_center_id == '125')
                    {
                        DB::table('problem_details')->insert(
                            ['docket_no' => $final_docket[0]->docket, 'sms_dkt' => $final_docket[0]->docket,'user_id'=>$user_id,'for_dept_id'=>$for_dept,'prob_reported_on'=>Carbon::now()->toDateTimeString(),'problem_desc'=>$prob_desc,'main_problem_type'=>$comp_type,'sub_problem_type'=>$sub_prob_type,'prob_status_code'=>$prob_status_code,'mobile'=>$mobile,'mode'=>$mode,'epabx'=>$epabx,'nodal_center_id'=>$nodal_center_id,'other_location'=>$other_loc]
                        );
                    }
                    else
                    {
                        DB::table('problem_details')->insert(
                            ['docket_no' => $final_docket[0]->docket, 'sms_dkt' => $final_docket[0]->docket,'user_id'=>$user_id,'for_dept_id'=>$for_dept,'prob_reported_on'=>Carbon::now()->toDateTimeString(),'problem_desc'=>$prob_desc,'main_problem_type'=>$comp_type,'sub_problem_type'=>$sub_prob_type,'prob_status_code'=>$prob_status_code,'mobile'=>$mobile,'mode'=>$mode,'epabx'=>$epabx,'nodal_center_id'=>$nodal_center_id]
                        );
                    }

                    //------------Fetching Docket Details--------------------
                    $docketDetails = DB::table('problem_details')
                    ->Join('users', 'problem_details.user_id', '=', 'users.user_id')
                    ->join('nodal_center','problem_details.nodal_center_id', '=', 'nodal_center.nodal_center_id')
                    ->select('problem_details.docket_no', 'users.user_name', 'nodal_center.*')
                    ->where('problem_details.docket_no', '=', $final_docket[0]->docket)
                    ->first();

                    $complainant_name =  $docketDetails->user_name;
                    $nodal_center_name = $docketDetails->nodal_center_name;
                    $location = $docketDetails->location;

                    $msg="New Complaint"."-".$final_docket[0]->docket."-".$complainant_name."-".$nodal_center_name."-".$location."-".$mobile."-".$epabx."-".$prob_desc;

                    if($ven_id != 'NA')
                    {
                        DB::table('problem_transactions')->insert(
                            ['docket_no' => $final_docket[0]->docket, 'assigned_from'=>$user_id,'dept_id'=>$for_dept,'service_id'=>$sub_prob_type,'assigned_time'=>Carbon::now()->toDateTimeString(),'action_taken'=>'V']
                        );
                        DB::table('problem_details')
                        ->where('docket_no', $final_docket[0]->docket)
                        ->update(['prob_status_code' => 'V']);

                        //------SMS & Email Alert For Vendors
                        $vendors = DB::table('vendor')
                        ->where('dept_id', '=', $for_dept)
                        ->where('vendor_id', '=', $ven_id)
                        ->get();

                        foreach($vendors as $vendor)
                        {
                            $ven_name=$vendor->vendor_name;
                            $mobile=$vendor->contact_number;
                            $to = $vendor->email;
                            $mobile = '9748002836';
                            $to= 'jayanta.ghosh@rp-sg.in';

                            $msg_admin="New Complaint given to vendor ".$ven_name."-".$final_docket[0]->docket."-".$complainant_name."-".$nodal_center_name."-".$location."-".$mobile."-".$epabx."-".$prob_desc;
                            $subject = "IT Helpdesk - Complaint given to vendor ".$ven_name;

                            /*if(isset($mobile))
                            {
                                send_sms($mobile, $msg);
                            }	*/
                            if(isset($to))
                            {
                                $controller->html_email($msg,$subject,$to);
                            }
                            $mobile=$vendor->contact_number2;
                            $to = $vendor->email2;
                            $mobile = '9748002836';
                            $to= 'jayanta.ghosh@rp-sg.in';
                           /* if(isset($mobile))
                            {
                                send_sms($mobile, $msg);
                            }	*/
                            if(isset($to))
                            {
                                $controller->html_email($msg,$subject,$to);
                            }
                            $mobile=$vendor->contact_number3;
                            $to = $vendor->email3;
                            $mobile = '9748002836';
                            $to= 'jayanta.ghosh@rp-sg.in';
                            /*if(isset($mobile))
                            {
                                send_sms($mobile, $msg);
                            }	*/
                            if(isset($to))
                            {
                                $controller->html_email($msg,$subject,$to);
                            }
                            $mobile=$vendor->contact_number4;
                            $to = $vendor->email4;
                            $mobile = '9748002836';
                            $to= 'jayanta.ghosh@rp-sg.in';
                           /* if(isset($mobile))
                            {
                                send_sms($mobile, $msg);
                            }	*/
                            if(isset($to))
                            {
                                $controller->html_email($msg,$subject,$to);
                            }
                        }
                   

                        $admins = DB::table('users')
                        ->where('user_dept_id', '=', $for_dept)
                        ->whereIn('user_type_code', array('A','B'))
                        ->get();
                        foreach($admins as $admin)
                        {
                            $mobile=$admin->mobile;
                            $mobile='9748002836';
                           // send_sms($mobile, $msg_admin);
                            
                            $to =$admin->email;
                            $to= 'jayanta.ghosh@rp-sg.in';
                            $controller->html_email($msg,$subject,$to);
                        }
                    }
                    $subject = "IT Helpdesk-New Complaint";
                    $users = DB::table("users")->select('*')
                    ->whereIn('user_id',function($query) use ($sub_prob_type){
                    $query->select('staff_id')->from('support_staff')->where('subproblem_code', '=',$sub_prob_type);
                    })
                    ->get();
                
                    
                    foreach($users as $user)
                    {
                    // $mobile=$user->mobile;
                        $mobile = '9748002836';
                        //if(isset($mobile))
                        //     send_sms($mobile, $msg);
                        
                        //$to=$user->email;
                        $to= 'jayanta.ghosh@rp-sg.in';
                        if(isset($to))
                            $controller->html_email($msg,$subject,$to);
                    }

                
                }
                $response["status"] = "Success";
                $response["docket_no"] = $final_docket[0]->docket;
                // echoing JSON response
		        echo json_encode($response);
              
            }
            catch (\Exception $e) {
              //  echo $e->getMessage();
                $response["status"] = $e->getMessage();
                $response["docket_no"] = "NA";
                // echoing JSON response
		        echo json_encode($response);
            }
            
    });


       
    }
    public function show($id)
    {
        //Get the task
        $task = ProblemDetails::findOrfail($id);
 
        // Return a single task
        return new Task($task);
    }
 
    public function destroy($id)
    {
        //Get the task
        $task = ProblemDetails::findOrfail($id);
 
        if($task->delete()) {
            return new Task($task);
        } 
 
    }
 
    public function docketStore(Request $request)  {
 
        $task = $request->isMethod('put') ? Task::findOrFail($request->$docket_no) : new ProblemDetails;
            
        $task->docket_no = $request->input('docket_no');
        $task->name = $request->input('name');
        $task->description = $request->input('description');
        $task->user_id =  1; //$request->user()->id;
 
        if($task->save()) {
            return new Task($task);
        } 
        
    }
   
    public function getSection()
    {
       $section = DB::connection('oracle')->table('VW_HW_SECTION_MASTER')->select('sec_code','sec_name')
        ->get();
       echo $section;
 
    }
 
   public function getRegion($section)
    {
       $region = DB::connection('oracle')->table('vw_hw_region_master')->select('region_code','region_name')
       ->whereIn('region_code',function ($query) use($section){
       $query->select('region_code')->from('vw_hw_device_details')
       ->where('sec_code','=',$section);
        })
	->get();
   echo $region;
}
  public function getDevtype()
  {
       $dev_name = DB::connection('oracle')->table('VW_HW_DEVICE_TYPE')->select('DEVICE_NAME')
        ->get();
       echo $dev_name;

  }

  public function getDevname($sec,$region,$dev_type)
  {
     $devname = DB::connection('oracle')->table('VW_HW_DEVICE_DETAILS')->select('MACHINE_NAME')
     ->where('VW_HW_DEVICE_DETAILS.sec_code', '=', $sec)
     ->where('VW_HW_DEVICE_DETAILS.region_code', '=', $region)
     ->where('VW_HW_DEVICE_DETAILS.device_type', '=', $dev_type)     
     ->orderBy('MACHINE_NAME')
     ->get();
     echo $devname;
  }

  public function generateDocketForMIS($user_id,$section,$region,$dev_type,$dev_name,$mobile,$prob_desc)
  {
   $comp_type = '1';
   $dept_id='02';
   $controller = new MailController();
   $subject = "IT Helpdesk - New Complaint"; 
  
   $prob_desc = urldecode($prob_desc); 
    // array for JSON response
        $response = array();
    try
           {
        $docket = DB::select(DB::raw('SELECT MAX(RIGHT(docket_no,7))+1 docket FROM problem_details WHERE SUBSTRING(docket_no,2,2)=RIGHT(YEAR(CURDATE()),2) AND  SUBSTRING(docket_no,4,2)=MONTH(CURDATE()) and left(docket_no,1)= :type'),array(
                    'type' => $comp_type,)) ;
                if(isset($docket[0]->docket))
                {
                    $final_docket = DB::select(DB::raw('SELECT CONCAT(:comp_type,LPAD(:docket,7,0)) docket'),array(
                        'comp_type' => $comp_type,'docket'=> $docket[0]->docket)) ;
                
                }  
                else
                {
                    $final_docket = DB::select(DB::raw('SELECT CONCAT(:comp_type,RPAD(CONCAT(SUBSTRING(YEAR(CURDATE()),3,2),LPAD(MONTH(CURDATE()),2,0)),6,0),1) docket'),array('comp_type' => $comp_type)); 
                }
      if(isset($final_docket))
      {
         
         $msg="New Complaint"."-".$final_docket[0]->docket."-".$section."-".$region."-".$dev_name."-".$prob_desc."-".$mobile;
         //********** Insert in IT Helpdesk *************************
         DB::table('problem_details')->insert(
                            ['docket_no' => $final_docket[0]->docket, 'sms_dkt' => $final_docket[0]->docket,'user_id'=>$user_id,'for_dept_id'=>$dept_id,'prob_reported_on'=>Carbon::now()->toDateTimeString(),'problem_desc'=>$prob_desc,'main_problem_type'=>$comp_type,'prob_status_code'=>'O','mobile'=>$mobile,'mode'=>'APP']
                        );

         //*********** Insert in Mains MIS HMS ***********************
       /*  DB::connection('oracle')->table('HW_MIS_CIS_INTERFACE')->insert(['DOCKET_HD' => $final_docket[0]->docket,'DOCKET' =>  DB::raw('sysdate'),'SEC_NAME' => $section,'DISTRICT' => $region,'DEV_TYPE' => $dev_type,'MACHINE_NAME' => $dev_name,REPORTED_BY => $user_id,'PROBLEM_DESCRIPTION' => $prob_desc,'FLAG_CIS' => 'N','DATE_CIS' => DB::raw('sysdate'),'REPORTED_BY_PHONE' => $mobile]); */
      
      //-----------------------------Inform MIS Personnel--------------------------------
     $mis_personnel = DB::connection('oracle')->table('VW_HW_USER_MASTER')->select('USER_NAME')
                      ->where('SEC_CODE', '=', $section)
                      ->get();
      
     $user_details = json_decode($mis_personnel, true);
     foreach($user_details as $i => $name)
            {
                //echo $name['user_name'];
                $contact_details = DB::table('users')->select('email','mobile')
                                   ->where('user_id', '=', $name['user_name'])
                                   ->get();
                $contacts = json_decode($contact_details , true);
                foreach($contacts as $i => $details)
                {
                    if(isset($details['email']))
                    {
                       $to=$details['email'];
                       $to='jayanta.ghosh@rp-sg.in';                      
                       $controller->html_email($msg,$subject,$to);
                    }

                    if(isset($details['mobile']))
                    {
                      
                      //send_sms($details['mobile'], $msg);
                    }
                }
          
            }
    
      }
       $response["status"] = "Success";
       $response["docket_no"] = $final_docket[0]->docket;
       // echoing JSON response
       echo json_encode($response);
       }
       catch (\Exception $e) {
              //  echo $e->getMessage();
                $response["status"] = $e->getMessage();
                $response["docket_no"] = "NA";
                // echoing JSON response
	        echo json_encode($response);
            }
  }
public function mis_test($section)
{
    //-----------------------------Inform MIS Personnel--------------------------------
     $mis_personnel = DB::connection('oracle')->table('VW_HW_USER_MASTER')->select('USER_NAME')
                      ->where('SEC_CODE', '=', $section)
                      ->get();

     $user_details = json_decode($mis_personnel, true);
     //echo $mis_personnel;
     foreach($user_details as $i => $name)
            {
                //echo $name['user_name'].',';
                 $contact_details = DB::table('users')->select('email','mobile')
                                   ->where('user_id', '=', $name['user_name'])
                                   ->get();
                $contacts = json_decode($contact_details , true);
                foreach($contacts as $i => $details)
                {
                    echo $details['email'].'-'. $details['mobile'];
                }


            }

}
}
