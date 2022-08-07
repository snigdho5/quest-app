<?php

namespace App\Http\Controllers\AppApiControllers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

use App\Models\AdminModels\StoreDeal;
use App\Models\AdminModels\Store;
use App\Models\AdminModels\StoreAppDeal;
use App\Models\AdminModels\StoreAppDealDayTime;
use App\Models\AdminModels\StoreAppDealClaimed;
use App\Models\AdminModels\StoreStaff;

use App\Mail\AppOfferRedeemed;

class CrmController extends Controller
{
	private $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
    private $apikey = 'AAAAkjXbvkg:APA91bGreefMBF9C7xg564EKpX7HJb10v-kVZx8eiw4z0GbjsV__5BUWMCCeZYHukenQUcUXQuQn4oINWrkLtG9Jg0CShTYSveo76bGdqBSBilWqEaOVvfcKVp3tF0bAk7bK50EAR166';

    public function __construct(){

    }

    public function getStoreList(){
        
        $data = Store::select('id','name')->where('active','1')->orderby("name")->get()->toArray();
        return json_encode($data);
    }

    public function sendOtp(Request $request){
        request()->merge(['phone' => Crypt::decryptString(request()->phone)]);

        // validation
        $validator = Validator::make($request->all(),[
            'phone' => 'required|digits:10'
        ]);

        if ($validator->fails()) {
            return response(json_encode($validator->errors()));
        }else{
        	$OTP = rand(10000,99999);
            $response = file_get_contents("http://5.189.187.82/sendsms/bulk.php?username=brandsum&password=12345678&type=TEXT&sender=QuestM&entityId=1701159179218527222&templateId=1707161737270600501&mobile=".request()->phone."&message=".urlencode($OTP." is your OTP for phone number verification. Valid for 15 minutes. QUEST PROPERTIES INDIA LTD."));

            return json_encode(array("success"=>Crypt::encryptString($OTP)));
        }
    }

    public function checklogin(Request $request){
    	request()->merge(['id' => Crypt::decryptString(request()->id)]);
    	request()->merge(['token' => Crypt::decryptString(request()->token)]);

    	if(StoreStaff::where([['id',request()->id],['token',request()->token]])->count()){
    		return 1;
    	}else return 0;
    }

    public function login(Request $request){
    	request()->merge(['name' => Crypt::decryptString(request()->name)]);
    	request()->merge(['phone' => Crypt::decryptString(request()->phone)]);
    	request()->merge(['store_id' => Crypt::decryptString(request()->store)]);

        // validation
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'store_id' => 'required',
            'phone' => 'required|digits:10'
        ]);
		
		if ($validator->fails()) {
            return response(json_encode($validator->errors()));
        }else{
        	$user = StoreStaff::where('phone',request()->phone);
        	if($user->count()){
        		$user = $user->first();
        		if($user->active == '1'){
        			$user->token = md5(time());
        			$user->save();
        			$arr = array(
        				'token'=>$user->token,
        				'id'=>$user->id,
        				'name'=>$user->name,
        				'phone'=>$user->phone,
        				'store_name'=>$user->store->name,
        				'store_logo'=>$user->store->logo
        			);
        			return json_encode(array("success"=>Crypt::encryptString(json_encode($arr))));
        		}else{
        			return json_encode(array("new"=>'Your account is under review. You can login after we verify your identity.'));
        		}
        	}else{
        		request()->merge(['token' => ""]);
        		StoreStaff::create(request()->all());
        		return json_encode(array("new"=>'Your account has been created and is under review. You can login after we verify your identity.'));
        	}
        }
    }

    public function logout(Request $request){
    	request()->merge(['id' => Crypt::decryptString(request()->id)]);
    	request()->merge(['token' => Crypt::decryptString(request()->token)]);

    	if(StoreStaff::where([['id',request()->id],['token',request()->token]])->count()){
    		$user = StoreStaff::where([['id',request()->id],['token',request()->token]])->first();
    		$user->token = "";
    		$user->save();
    		return 1;
    	}else return 0;
    }

    public function verifyQrCode(Request $request){
    	request()->merge(['id' => Crypt::decryptString(request()->id)]);
    	request()->merge(['token' => Crypt::decryptString(request()->token)]);
    	request()->merge(['code' => Crypt::decryptString(request()->code)]);

        // validation
        $validator = Validator::make($request->all(),[
            'id' => 'required',
            'token' => 'required',
            'code' => 'required'
        ]);
		
		if ($validator->fails()) {
            return response(json_encode($validator->errors()));
        }else{
        	$staff = StoreStaff::where([['active',1],['id',request()->id],['token',request()->token]]);
        	if($staff->count()){
        		$staff = $staff->first();

        		$userCode = StoreAppDealClaimed::where([['store_id', $staff->store_id],['code',strtoupper(request()->code)]]);
        		if ($userCode->count() == 0){
	                return json_encode(array("error"=>"Invalid coupon code!"));
	            }else{
	            	$userCode = $userCode->first();
	                $offer = $userCode->offer;
	                if($userCode->claimed == 0){
	                    if($offer->active == 1 and $offer->start_date->timestamp <= time() and strtotime('+1day',$offer->end_date->timestamp) >= time()){
	                        $data = $userCode;

	                        $activeday = $data->offer->activeday->where('day',date("l"));
	                        if($activeday->count()){
	                            $activeday=$activeday->first();
	                            if(strtotime(date('Y-m-d ').$activeday->fromtime) <= time() and strtotime(date('Y-m-d ').$activeday->totime) >= time()){
	                                $available = true;
	                            }
	                            else $available = false;
	                        }else $available = false;
	                        
	                        if($available){
	                        	$dataToSend = array(
	                        		"user" => array(
	                        			"name" => $data->user->name,
	                        			"email" => $data->user->email,
	                        			"phone" => $data->user->phone,
	                        			"code" => request()->code,
	                        		),
	                        		"offer" => array(
	                        			"title" => $offer->title,
	                        			"description" => $offer->description,
	                        			"start_date" => $offer->start_date->format('d M, Y'),
	                        			"end_date" => $offer->end_date->format('d M, Y'),
	                        		),
	                        	);

	                        	return json_encode(array("success"=>Crypt::encryptString(json_encode($dataToSend))));
	                        }else{
	                        	return json_encode(array("error"=>"Currently the offer is not available! Please check the offer availability below."));
	                        }
	                    }else{
	                        return json_encode(array("error"=>"Invalied offer!"));
	                    }
	                }else{
	                    return json_encode(array("error"=>"Coupon code has already been redeemed!"));
	                }
	            }
        	}else return json_encode(array("error"=>"Invalid request! Please restart you app."));
        }
    }

    public function submitOffer(Request $request){
    	request()->merge(['id' => Crypt::decryptString(request()->id)]);
    	request()->merge(['token' => Crypt::decryptString(request()->token)]);
    	request()->merge(['code' => Crypt::decryptString(request()->code)]);
    	request()->merge(['amount' => Crypt::decryptString(request()->amount)]);

        // validation
        $validator = Validator::make($request->all(),[
            'id' => 'required',
            'token' => 'required',
            'code' => 'required',
            'amount' => 'required|numeric',
        ]);
		
		if ($validator->fails()) {
            return response(json_encode($validator->errors()));
        }else{
        	$staff = StoreStaff::where([['active',1],['id',request()->id],['token',request()->token]]);
        	if($staff->count()){
        		$staff = $staff->first();

        		$userCode = StoreAppDealClaimed::where([['store_id', $staff->store_id],['code',strtoupper(request()->code)]]);
        		if ($userCode->count() == 0){
	                return json_encode(array("error"=>"Invalid coupon code!"));
	            }else{
	            	$userCode = $userCode->first();
	                $offer = $userCode->offer;
	                if($userCode->claimed == 0){
	                    if($offer->active == 1 and $offer->start_date->timestamp <= time() and strtotime('+1day',$offer->end_date->timestamp) >= time()){
	                        $data = $userCode;

	                        $activeday = $data->offer->activeday->where('day',date("l"));
	                        if($activeday->count()){
	                            $activeday=$activeday->first();
	                            if(strtotime(date('Y-m-d ').$activeday->fromtime) <= time() and strtotime(date('Y-m-d ').$activeday->totime) >= time()){
	                                $available = true;
	                            }
	                            else $available = false;
	                        }else $available = false;
	                        
	                        if($available){
	                        	
	                        	$data->offer_title = $data->offer->title;
                                $data->claimed = 1;
                                $data->staff_id = $staff->id;
                                $data->staff_name = $staff->name;
				                $data->staff_phone = $staff->phone;
				                $data->amount = request('amount');
				                $data->save();


				                $ndata = ['appOffer' =>$data->offer_title,'user_id' =>$data->user_id];
				                $headers = ['Authorization: key=' . $this->apikey,'Content-Type: application/json'];

				                $fcmNotification = [
				                    'to' => '/topics/user_'.$data->user_id,
				                    'data' => $ndata,
				                    'time_to_live' => 3600,
				                    'priority'=>'high',
				                    "content_available"=> true,
				                    "mutable_content"=> true,
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

				                Mail::to($data->user->email, $data->user->name)->send(new AppOfferRedeemed($data));

	                        	return json_encode(array("success"=>""));
	                        }else{
	                        	return json_encode(array("error"=>"Currently the offer is not available! Please check the offer availability below."));
	                        }
	                    }else{
	                        return json_encode(array("error"=>"Invalied offer!"));
	                    }
	                }else{
	                    return json_encode(array("error"=>"Coupon code has already been redeemed!"));
	                }
	            }
        	}else return json_encode(array("error"=>"Invalid request! Please restart you app."));
        }
    }

    public function loadHistory(Request $request){
    	request()->merge(['id' => Crypt::decryptString(request()->id)]);
    	request()->merge(['token' => Crypt::decryptString(request()->token)]);
    	request()->merge(['start_date' => Crypt::decryptString(request()->start_date)]);
    	request()->merge(['end_date' => Crypt::decryptString(request()->end_date)]);

        // validation
        $validator = Validator::make($request->all(),[
            'id' => 'required',
            'token' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);
		
		if ($validator->fails()) {
            return response(json_encode($validator->errors()));
        }else{
        	$staff = StoreStaff::where([['active',1],['id',request()->id],['token',request()->token]]);
        	if($staff->count()){
        		$staff = $staff->first();

        		$claimedOffers = StoreAppDealClaimed::select(\DB::raw('*,DATE_FORMAT(`updated_at`, "%b %d, %Y") as `trans_date`'))->with('user')->where('store_id', $staff->store_id)->where('claimed',1);
                $start = request('start_date').' 00:00:00';
                $end   = request('end_date').' 23:59:59';
                $claimedOffers = $claimedOffers->whereBetween('updated_at', [$start, $end])->orderBy('updated_at','desc')->get();

                return Crypt::encryptString(json_encode($claimedOffers->toArray()));

        	}else return json_encode(array("error"=>"Invalid request! Please restart you app."));
        }
    }
}
