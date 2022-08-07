<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\AdminModels\UserWalkOffer;
use App\Models\AdminModels\EntryBooking;

class DashboardController extends Controller
{
    public function __construct(){
    	$this->middleware('auth:admin');
    }

    public function index(){
    	$total_user = User::count();
		$wnw_redeem = UserWalkOffer::count();
		$wnw_user = User::where('total_steps','>',0)->count();
		$total_booking = EntryBooking::count();
		$today_booking = EntryBooking::whereDate('date',date('Y-m-d'))->where('status','!=',0)->count();
		$cancel_booking = EntryBooking::where('status',0)->count();
		$today_cancel_booking = EntryBooking::whereDate('date',date('Y-m-d'))->where('status',0)->count();
		$entry_booking = EntryBooking::where('status',2)->count();
		$today_entry_booking = EntryBooking::whereDate('date',date('Y-m-d'))->where('status',2)->count();
		$exit_booking = EntryBooking::where('status',-1)->count();
		$today_exit_booking = EntryBooking::whereDate('date',date('Y-m-d'))->where('status',-1)->count();

		$no_booking = EntryBooking::whereDate('date','<',date('Y-m-d'))->where('status',1)->count();

		return view('admin.dashboard_new',compact('total_user','wnw_redeem','wnw_user','total_booking','today_booking','cancel_booking','entry_booking','exit_booking','no_booking','today_cancel_booking','today_entry_booking','today_exit_booking'));
    }
}
