<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomLibrary\CaptchaController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;

class LoginController extends Controller
{
	use AuthenticatesUsers;

    public function __construct(){
    	$this->middleware('guest:admin')->except('destroy');
    	\Auth::shouldUse('admin');
    }


    public function show(){
        // $alldata = User::all();
        // foreach ($alldata as $key => $value) {
        //     if($value->step_data != null){

        //         $total_step = json_decode($value->step_data);
        //         $total = 0;
        //         foreach ($total_step as $v) {
        //             $total = $total + $v;
        //         }

        //         $value->total_steps = $total;
        //         $value->save();
        //     }
        // }

        CaptchaController::generate('#000','#f4f4f4',150,50,50,200,'#888');
    	return view('admin.login');
    }

    public function create(){

    	$this->validate(request(),[
    		'username' => 'required',
    		'password' => 'required|min:3',
            'captcha'  => 'required|captcha'
    	]);

    	request()->merge(['active' => '1']);

    	if(auth()->attempt(request(['username','password', 'active']),false)){
            CaptchaController::destroy();
    		return redirect()->route('admin::dashboard');
    	}else return back()->withErrors(['loginError'=>'Please check your credentials!'])->withInput(request()->except('password'));

    }

    public function destroy(){
    	auth()->logout();
    	return redirect()->route('admin::login');
    }
}
