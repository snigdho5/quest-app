<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\AdminModels\EntryBooking;
use App\Models\AdminModels\EntrySlots;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EntryBookingController extends Controller
{
    protected $access_type;

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
        $access_type = $this->access_type;

        $where = [];
        if(request()->has('others')){
            if(request()->others <> "Any") array_push($where, ['child',(request()->others-1)]);
        }
        if(request()->has('slot')){
            if(request()->slot <> "All") array_push($where, ['slot',request()->slot]);
        }
        if(request()->has('status')){
            if(request()->status == "Cancelled") array_push($where, ['status',0]);
            if(request()->status == "Entry Logged") array_push($where, ['status',2]);
            if(request()->status == "Exit Logged") array_push($where, ['status',-1]);
            if(request()->status == "Booked" || request()->status == "No Show") array_push($where, ['status',1]);
        }

        $entry = EntryBooking::where($where);

        if(request()->sdate and request()->edate){
            $entry = $entry->whereBetween('date', [request()->sdate, request()->edate]);
        }

        $data = $entry->get();

        $slots = EntrySlots::where('active',1)->get();
        return view('admin.entry_booking.index',compact('data','access_type','slots'));
    }
}
