<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mail;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MailController extends Controller {
   public function basic_email(){
      $data = array('name'=>"Helpdesk");
   
      Mail::send(['text'=>'mail'], $data, function($message) {
         $message->to('jghosh.24@gmail.com', 'Tutorials Point')->subject
            ('Laravel Basic Testing Mail');
         $message->from('generation_helpdesk@cesc.co.in','Generation IT Helpdesk');
      });
      echo "Basic Email Sent. Check your inbox.";
   }
   public function html_email($msg,$subject,$to,$issue_type){
      $data = array('name'=>$msg,'to'=>$to,'subject'=>$subject);
      Mail::send('mail', $data, function($message) use($to,$subject,$issue_type) {
	 $message->to($to, 'IT Helpdesk');
	 if($issue_type == '1' || $issue_type == '2' || $issue_type == '3' || $issue_type == '4' || $issue_type == '5')
	 {
                     $message->cc('rakesh.kumar@rpsg.in');
		     $message->cc('prasanta.ranjit@rpsg.in');
		     $message->cc('abhijit.das@rpsg.in');
		     $message->cc('chiranjib.ghosh@rpsg.in');
	             $message->cc('sanjeev.mehra@rpsg.in');
	             $message->cc('tirtho.banerjee@rpsg.in');
	             $message->cc('trideep.saha@rpsg.in');
                     $message->cc('kowsik.roy@rpsg.in');
         }
         if($issue_type == '6' || $issue_type == '7' || $issue_type == '8' || $issue_type == '9' || $issue_type == '10' || $issue_type == '11')
         {
                     $message->cc('sanjeev.mehra@rpsg.in');
                     $message->cc('tirtho.banerjee@rpsg.in');
                     $message->cc('trideep.saha@rpsg.in');
                     $message->cc('kowsik.roy@rpsg.in');
         }
         if($issue_type == '12' || $issue_type == '13' || $issue_type == '14' || $issue_type == '15' || $issue_type == '16')
	 {
		     $message->cc('sanjeev.mehra@rpsg.in');
		     $message->cc('tirtho.banerjee@rpsg.in');
		     $message->cc('trideep.saha@rpsg.in');
		     $message->cc('kowsik.roy@rpsg.in');
         }
         if($issue_type == '18' || $issue_type == '19' || $issue_type == '20')
	 {
		     $message->cc('soumya.k.majumdar@rpsg.in');
		     $message->cc('neha.agarwal@rpsg.in');
		     $message->cc('sanjeev.mehra@rpsg.in');
		     $message->cc('tirtho.banerjee@rpsg.in');
		     $message->cc('trideep.saha@rpsg.in');
		     $message->cc('kowsik.roy@rpsg.in');
	 }
         if($issue_type == '21' || $issue_type == '22' || $issue_type == '23' || $issue_type == '24' || $issue_type == '25')
	 {
	             $message->cc('chandra.mijar@rpsg.in');
		     $message->cc('sanjeev.mehra@rpsg.in');
		     $message->cc('tirtho.banerjee@rpsg.in');
		     $message->cc('trideep.saha@rpsg.in');
	             $message->cc('kowsik.roy@rpsg.in');
	 }



         $message->subject($subject);
         $message->from('co_helpdesk@rpsg.in','Quest Helpdesk');
      });
   }
   public function html_email_user($msg,$subject,$to){
      $data = array('name'=>$msg,'to'=>$to,'subject'=>$subject);
      Mail::send('mail', $data, function($message) use($to,$subject) {
        // $message->to($to, 'IT Helpdesk');
         $message->to($to);
         $message->subject($subject);
         $message->from('co_helpdesk@rpsg.in','Quest Service Desk');
      });
   }
    public function otp_email($msg,$subject,$to){
      $data = array('name'=>$msg,'to'=>$to,'subject'=>$subject);
      Mail::send('mail', $data, function($message) use($to,$subject) {
        // $message->to($to, 'IT Helpdesk');
         $message->to($to);
         $message->subject($subject);
         $message->from('co_helpdesk@rpsg.in','Quest Service Desk');
      });
   }

   public function attachment_email(){
      $data = array('name'=>"Virat Gandhi");
      Mail::send('mail', $data, function($message) {
         $message->to('abc@gmail.com', 'Tutorials Point')->subject
            ('Laravel Testing Mail with Attachment');
         $message->attach('C:\laravel-master\laravel\public\uploads\image.png');
         $message->attach('C:\laravel-master\laravel\public\uploads\test.txt');
         $message->from('xyz@gmail.com','Virat Gandhi');
      });
      echo "Email Sent with attachment. Check your inbox.";
   }
}
