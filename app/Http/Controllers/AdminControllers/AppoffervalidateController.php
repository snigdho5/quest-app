<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\AdminModels\StoreAppDeal;
use App\Models\AdminModels\StoreAppDealDayTime;
use App\Models\AdminModels\StoreAppDealClaimed;
use App\Models\AdminModels\Store;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CustomLibrary\CaptchaController;

use Illuminate\Support\Facades\Mail;
use App\Mail\AppOfferRedeemed;

class AppoffervalidateController extends Controller
{
    private $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
    private $apikey = 'AAAAkjXbvkg:APA91bGreefMBF9C7xg564EKpX7HJb10v-kVZx8eiw4z0GbjsV__5BUWMCCeZYHukenQUcUXQuQn4oINWrkLtG9Jg0CShTYSveo76bGdqBSBilWqEaOVvfcKVp3tF0bAk7bK50EAR166';

    public function __construct(){

    }

    public function index()
    {
        if(\Session::has('store_id')){
            return redirect()->route('admin::appOfferValidate');
        }else{
            CaptchaController::generate('#000','#f4f4f4',150,50,50,200,'#888');
            return view('admin.appOfferValidate.login');
        }
    }

    public function check(){
        $this->validate(request(),[
            'id' => 'required',
            'password' => 'required|min:3',
            'captcha'  => 'required|captcha'
        ]);


        if(Store::where([['id',request()->id],['login_id',request()->password]])->count() == 1){
            CaptchaController::destroy();
            \Session::put('store_id',request()->id);
            return redirect()->route('admin::appOfferValidate');
        }else return back()->withErrors(['loginError'=>'Please check your credentials!']);
    }

    public function list(Request $request)
    {
        $message = [];
        if(\Session::has('store_id')){

            $claimedOffers = StoreAppDealClaimed::where('store_id', \Session::get('store_id'))->where('claimed',1);

            if(request('start_date')){
                $start = request('start_date').' 00:00:00';
                $end   = request('end_date').' 23:59:59';
                $claimedOffers = $claimedOffers->whereBetween('updated_at', [$start, $end])->get();
            }else{
                $claimedOffers = $claimedOffers->get();
            }

            $data  =[];
            $available = false;


            if(request('unique_code')){
                $userCode = StoreAppDealClaimed::where([['store_id', \Session::get('store_id')],['code',strtoupper(request('unique_code'))]]);
                if ($userCode->count() == 0){
                     $message =  array("error"=>"Invalid coupon code!");
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
                            }else{
                                $available = false;
                            }
                        }else{
                            $message = array("error"=>"Invalied offer!");
                        }
                    }else{
                        $message = array("error"=>"Coupon code has been redeemed!");
                    }
                }
            }


            if(request('submit') and $available and count($message)==0){
                $this->validate(request(),[
                    'amount' => 'required'
                ]);

                $data->offer_title = $data->offer->title;
                $data->claimed = 1;
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


                session()->flash('success','Offer code accepted! The customer has been notified via email and in-app notification.');
                return redirect()->route('admin::appOfferValidate');
            }

            return view('admin.appOfferValidate.list',compact('data','message','claimedOffers','available'));
        }else{
            return redirect()->route('admin::appOfferValidate_logout');
        }
    }

    public function logout(){
        \Session::forget('store_id');
        return redirect()->route('admin::appOfferValidate_login');
    }
}
