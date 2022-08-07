<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\AdminModels\Contest;
use App\Models\AdminModels\ContestDine;
use App\Models\AdminModels\ContestParticipantTransaction;
use App\Models\AdminModels\ContestParticipate;
use App\Models\AdminModels\ContestThreshold;




use App\Models\AdminModels\UserWalkOffer;
use App\Models\AdminModels\WalkLevel;
use App\Models\AdminModels\Store;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CustomLibrary\CaptchaController;

use Illuminate\Support\Facades\Mail;
use App\Mail\OfferRedeemed;

class ContestvalidateController extends Controller
{
    private $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
    private $apikey = 'AAAAkjXbvkg:APA91bGreefMBF9C7xg564EKpX7HJb10v-kVZx8eiw4z0GbjsV__5BUWMCCeZYHukenQUcUXQuQn4oINWrkLtG9Jg0CShTYSveo76bGdqBSBilWqEaOVvfcKVp3tF0bAk7bK50EAR166';

    public function __construct(){

    }

    public function index()
    {
        if(\Session::has('store_id')){
            return redirect()->route('admin::contestvalidate');
        }else{
            CaptchaController::generate('#000','#f4f4f4',150,50,50,200,'#888');
            return view('admin.contestvalidate.login');
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
            return redirect()->route('admin::contestvalidate');
        }else return back()->withErrors(['loginError'=>'Please check your credentials!']);
    }

    public function list(Request $request)
    {
        $message = [];
        if(\Session::has('store_id')){


            if(request('start_date')){

                if(request('dine_id') != 'all') $allTrandsaction = ContestParticipantTransaction::where('dine_id', request('dine_id'));
                else $allTrandsaction = ContestParticipantTransaction::where('dine_id','>','0');

                $start = request('start_date').' 00:00:00';
                $end   = request('end_date').' 23:59:59';
                $allTrandsaction = $allTrandsaction->whereBetween('trans_date', [$start, $end])->get();
            }else{
                $allTrandsaction = ContestParticipantTransaction::where('dine_id', \Session::get('store_id'))->get();
            }

            $allContestOfDine =  ContestDine::where('dine_id',\Session::get('store_id'))->get();

            $contest = Contest::select('name','id', 'unlimited')->where([['active','1'],['id',$allContestOfDine->first()->contest_id]]);
            if ($contest->count()){
                $contest = $contest->first();
                $contest->connectedDine = $contest->dines->where('dine_id',\Session::get('store_id'));
                $contest->connectedFC = $contest->fc_outlets->where('dine_id',\Session::get('store_id'));

                if($contest->connectedDine->count() > 0 || $contest->connectedFC->count() > 0){
                    if($contest->connectedFC->count() > 0) $type = 0;
                    if($contest->connectedDine->count() > 0) $type = 1;
                }
            }

            $data  =[];


            if(request('unique_code')){
                $contest = Contest::select('name','id', 'unlimited')->where([['active','1'],['form_date','<=',date('Y-m-d 00:00:00')],['to_date','>=',date('Y-m-d 23:59:59')]]);
                if ($contest->count() == 0){
                     $message =  array("error"=>"No contest found!");
                }else{
                    $contest = $contest->first();
                    $contest_id = $contest->id;

                    $data = ContestParticipate::where([['contest_id',$contest_id],['unique_code',request()->unique_code]]);
                    if($data->count()){
                        $data = $data->first();
                        $contest->connectedDine = $contest->dines->where('dine_id',\Session::get('store_id'));
                        $contest->connectedFC = $contest->fc_outlets->where('dine_id',\Session::get('store_id'));

                        if($contest->connectedDine->count() > 0 || $contest->connectedFC->count() > 0){

                            if($contest->connectedFC->count() > 0) $type = 0;
                            if($contest->connectedDine->count() > 0) $type = 1;

                            if($contest->participants->where('user_id',$data->user_id)->first()->transactions->where('type',$type)->whereBetween('trans_date', [date('Y-m-01'), date('Y-m-t')])->count() > 0){
                                $contest->userTransaction = $contest->participants->where('user_id',$data->user_id)->first()->transactions->where('type',$type)->whereBetween('trans_date', [date('Y-m-01'), date('Y-m-t')])->last()->percentage;
                            }else{
                                $contest->userTransaction = 0;
                            }
                            $contest->thresholdPercentage = $contest->thresholdDetails->where('type',$type)->pluck("percentage");

                            if($contest->unlimited == 0){
                                $index = $contest->thresholdPercentage->search($contest->userTransaction);
                                if($contest->thresholdPercentage->count()==$index+1){
                                    $message = array("error"=>"No more offer available for this user!");
                                }
                            }
                        }else{
                            $message = array("error"=>"No offer available for this dine!");
                        }

                    }else{
                        $message = array("error"=>"No user found!");
                    }
                }
            }


            if(request('submit')){

                $index = $contest->thresholdPercentage->search($contest->userTransaction);
                if($index!==false){
                   $discount = $contest->thresholdPercentage->get($index+1);
                 }else{
                   $discount = $contest->thresholdPercentage->get(0);
                 }


                if($contest->thresholdPercentage->count()==$index+1){
                  $discount = $contest->thresholdPercentage->get($index);
                }

                if($discount> 0){
                    ContestParticipantTransaction::create([
                        'participant_id'=>$data->id,
                        'dine_id'=>\Session::get('store_id'),
                        'thresehold_id'=>$contest->thresholdDetails->where('percentage',$discount)->first()->id,
                        'unique_code'=>$data->unique_code,
                        'percentage'=>$discount,
                        'trans_amount'=>request('trans_amount'),
                        'trans_date'=>date('Y-m-d'),
                        'type'=>$type,
                    ]);


                    $ndata = ['contest' =>'1','user_id' =>$data->user_id, 'type' => $type];
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


                    session()->flash('success','Transaction added successfull!');
                    return redirect()->route('admin::contestvalidate');
                }
            }

            return view('admin.contestvalidate.list',compact('data','message','contest','allTrandsaction','allContestOfDine','type'));
        }else{
            return redirect()->route('admin::contestvalidate_logout');
        }
    }

    public function logout(){
        \Session::forget('store_id');
        return redirect()->route('admin::contestvalidate_login');
    }

    public function update($id)
    {
        UserWalkOffer::where([['id',$id],['store_id',\Session::get('store_id')]])->update(['used_date'=>date('Y-m-d H:i:s')]);

        $data = UserWalkOffer::where([['id',$id],['store_id',\Session::get('store_id')]])->first();
        Mail::to($data->user->email, $data->user->name)->send(new OfferRedeemed($data));

        session()->flash('success','Walk and win offer status changed successfully.');
        return redirect()->route('admin::contestvalidate');
    }
}
