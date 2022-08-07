<?php

namespace App\Http\Controllers\AdminControllers\StorePanel;

use App\Models\AdminModels\Store;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CustomLibrary\CaptchaController;

class StoreLoginController extends Controller
{
    public function __construct(){

    }

    public function index()
    {
        if(\Session::has('store_id')){
            return redirect()->route('admin::storePanel::home');
        }else{
            CaptchaController::generate('#000','#f4f4f4',150,50,50,200,'#888');
            return view('admin.storepanel.login');
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
            return redirect()->route('admin::storePanel::home');
        }else return back()->withErrors(['loginError'=>'Please check your credentials!']);
    }

    public function logout(){
        \Session::forget('store_id');
        return redirect()->route('admin::storePanel::login');
    }
}
