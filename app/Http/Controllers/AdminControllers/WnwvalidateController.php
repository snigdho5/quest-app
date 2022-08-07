<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\AdminModels\UserWalkOffer;
use App\Models\AdminModels\WalkLevel;
use App\Models\AdminModels\Store;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CustomLibrary\CaptchaController;

use Illuminate\Support\Facades\Mail;
use App\Mail\OfferRedeemed;

class WnwvalidateController extends Controller
{

    public function __construct(){

    }

    public function index()
    {
        if(\Session::has('store_id')){
            return redirect()->route('admin::userwnw');
        }else{
            CaptchaController::generate('#000','#f4f4f4',150,50,50,200,'#888');
            return view('admin.wnwvalidate.login');
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
            return redirect()->route('admin::userwnw');
        }else return back()->withErrors(['loginError'=>'Please check your credentials!']);
    }

    public function list()
    {
        if(\Session::has('store_id')){
            $data = UserWalkOffer::where('store_id',\Session::get('store_id'))->get();
            return view('admin.wnwvalidate.list',compact('data'));
        }else{
            return redirect()->route('admin::userwnw_logout');
        }
    }

    public function logout(){
        \Session::forget('store_id');
        return redirect()->route('admin::userwnw_login');
    }

    public function update($id)
    {
        UserWalkOffer::where([['id',$id],['store_id',\Session::get('store_id')]])->update(['used_date'=>date('Y-m-d H:i:s')]);

        $data = UserWalkOffer::where([['id',$id],['store_id',\Session::get('store_id')]])->first();
        Mail::to($data->user->email, $data->user->name)->send(new OfferRedeemed($data));

        session()->flash('success','Walk and win offer status changed successfully.');
        return redirect()->route('admin::userwnw');
    }
}
