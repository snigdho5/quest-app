<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\AdminModels\AppPush;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class AppPushController extends Controller
{
    private $uploadPath = 'app_push/actual/';
    protected $access_type;
    private $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
    private $apikey = 'AAAAkjXbvkg:APA91bGreefMBF9C7xg564EKpX7HJb10v-kVZx8eiw4z0GbjsV__5BUWMCCeZYHukenQUcUXQuQn4oINWrkLtG9Jg0CShTYSveo76bGdqBSBilWqEaOVvfcKVp3tF0bAk7bK50EAR166';


    public function __construct(){
        $this->middleware('auth:admin');
        $this->middleware(function ($request, $next) {
            $this->access_type = checkAccess(auth()->guard('admin')->user()->role);
            if(count($this->access_type)==0) abort(403);
            return $next($request);
        });
    }

    public function index()
    {
        // $this->testNotification();
        $access_type = $this->access_type;
        $data = AppPush::all();
        return view('admin.app_push.index',compact('data','access_type'));
    }


    public function create()
    {
        abort_unless(in_array('add',$this->access_type), 403);
        return view('admin.app_push.create');
    }

    public function store(Request $request)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'body' => 'required',
            'imagefile' => 'image|mimes:jpeg,jpg|max:512',
            'type' => 'required',
            'push' => 'required'
        ]);
	    if (request()->subtext) request()->merge(['subtext' => request()->subtext]);
        else request()->merge(['subtext' => ""]);

        if (request()->hasFile('imagefile')) {
            $image = request()->imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
                return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
            }
            request()->merge(['image' => $imagename]);
	    }

        // insert into database
        $appPush = AppPush::create(request()->all());
        if(request()->push == 1) $this->fbm_post($appPush->id);

        // set message and redirect
        session()->flash('success','Push Notification added successfully.');
        return redirect()->route('admin::appPush');
    }

    public function edit($id, AppPush $app_push)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $app_push->find($id);
        return view('admin.app_push.edit',compact('data'));
    }

    public function update($id, Request $request, AppPush $app_push)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'body' => 'required',
            'imagefile' => 'image|mimes:jpeg,jpg|max:512',
            'type' => 'required',
            'push' => 'required'
        ]);
        if (request()->subtext) request()->merge(['subtext' => request()->subtext]);
        else request()->merge(['subtext' => ""]);

        $app_push = $app_push->find($id);

        if (request()->hasFile('imagefile')) {
            $image = request()->imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
                return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
            }
            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath.$app_push->image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$app_push->image);

            request()->merge(['image' => $imagename]);
        }

        // update database
        $app_push->update(request()->all());
        $app_push->save();

        if(request()->push == 1) $this->fbm_post($app_push->id);

        // set message and redirect
        session()->flash('success','Push Notification updated successfully.');
        return redirect()->route('admin::appPush');
    }

    public function destroy($id, AppPush $app_push)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $app_push = $app_push->find($id);

        if ($app_push->push == 0){
	        // delete file
	        $old_file = Storage::disk('public')->path($this->uploadPath.$app_push->image);
	        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$app_push->image);

	        // delete data
	        $app_push->delete();

	        // set message and redirect
	        session()->flash('success','Push Notification deleted successfully.');
        }else{
	    	session()->flash('error ','Triggered Push Notification cannot be deleted.');
        }
        return redirect()->route('admin::appPush');
    }

    public function trigger($id){
    	abort_unless(in_array('trigger',$this->access_type), 403);
        $app_push = AppPush::find($id);

        if ($app_push->push == 0){

        	$this->fbm_post($id);

			session()->flash('success','Push Notification sended to app users successfully.');
        }

        return redirect()->route('admin::appPush');


    }


    public function fbm_post($id){
        $app_push = AppPush::find($id);


        $data = [
            'type' =>$app_push->type,
            'activity' =>$app_push->activity,
            'action' =>$app_push->action,
            'image' =>$app_push->image!=""?'http://www.questmall.in/storage/app_push/actual/'.$app_push->image:'',
            'subText' => $app_push->subtext,
            'title' =>$app_push->title,
            'body' => $app_push->body
        ];
        
        $fcmNotification = [
            'to' => '/topics/questAppPushMessage',
            'time_to_live' => 18000,
            'data' => $data
        ];

        $headers = ['Authorization: key=' . $this->apikey, 'Content-Type: application/json'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$this->fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);

        $data = [
            'type' =>$app_push->type,
            'activity' =>$app_push->activity,
            'action' =>$app_push->action,
            'attachment-url' =>$app_push->image!=""?'https://questmall.in/storage/app_push/actual/'.$app_push->image:'',
            'subText' => $app_push->subtext,
            'title' =>$app_push->title,
            'body' => $app_push->body
        ];
        $fcmNotification = [
        	'priority'=>'high',
			"content_available"=> true,
			"mutable_content"=> true,
			'time_to_live' => 18000,
            'to' => '/topics/ios_questAppPushMessage',
            "notification" => array(
		      "body" =>  $app_push->body,
		      "title" => $app_push->title,
		      "subtitle" => $app_push->subtext,
		      'sound' => 'default',
		      'badge' => '0'
		     ),
            'data' => $data
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$this->fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($result);
        AppPush::find($id)->update(['push'=>'1','push_id'=>$result->message_id]);
    }


    private function testNotification(){
        $app_push = AppPush::find(72);
        // $data = [
        //     'type' =>$app_push->type,
        //     'activity' =>$app_push->activity,
        //     'action' =>$app_push->action,
        //     'image' =>$app_push->image!=""?'http://www.questmall.in/storage/app_push/actual/'.$app_push->image:'',
        //     'subText' => $app_push->subtext,
        //     'title' =>$app_push->title,
        //     'body' => $app_push->body
        // ];
        
        // $fcmNotification = [
        //     'to' => '/topics/questAppPushMessage_test',
        //     'time_to_live' => 18000,
        //     'data' => $data
        // ];

        $headers = ['Authorization: key=' . $this->apikey, 'Content-Type: application/json'];

        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL,$this->fcmUrl);
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        // $result = curl_exec($ch);
        // curl_close($ch);

        $data = [
            'type' =>$app_push->type,
            'activity' =>$app_push->activity,
            'action' =>$app_push->action,
            'attachment-url' =>$app_push->image!=""?'https://questmall.in/storage/app_push/actual/'.$app_push->image:'',
            'subText' => $app_push->subtext,
            'title' =>$app_push->title,
            'body' => $app_push->body
        ];
        $fcmNotification = [
            'priority'=>'high',
            "content_available"=> true,
            "mutable_content"=> true,
            'time_to_live' => 18000,
            'to' => '/topics/ios_questAppPushMessage_test',
            "notification" => array(
              "body" =>  $app_push->body,
              "title" => $app_push->title,
              "subtitle" => $app_push->subtext,
              'sound' => 'default',
              'badge' => '0'
             ),
            'data' => $data
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$this->fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);
    }
}