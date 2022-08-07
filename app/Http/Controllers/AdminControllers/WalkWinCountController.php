<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class WalkWinCountController extends Controller
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

    public function index(Request $request)
    {
        $access_type = $this->access_type;
        
        
        if(request('start_date')){
            $begin = new \DateTime(request('start_date').' 00:00:00');
            $end = new \DateTime(request('end_date').' 23:59:59');


            $interval = \DateInterval::createFromDateString('1 day');
            $period = new \DatePeriod($begin, $interval, $end);

            

            $alldata = User::all()->toArray();
            foreach ($alldata as $key => $value) {
                if($value['step_data'] != null){
                    $total_step = json_decode($value['step_data'],true);
                    $total = 0;
                    foreach ($period as $dt) {
                        if(array_key_exists($dt->format("d-m-Y"), $total_step)){


                            $total = $total + $total_step[$dt->format("d-m-Y")];
                        }
                    }
                    $alldata[$key]['total_steps'] =  $total;
                   
                }
            }
        }else{

            $alldata = User::all();
            foreach ($alldata as $key => $value) {
                if($value->step_data != null){

                    $total_step = json_decode($value->step_data);
                    $total = 0;
                    foreach ($total_step as $v) {
                        $total = $total + $v;
                    }

                    $value->total_steps = $total;
                    $value->save();
                }
            }
            $alldata = $alldata->toArray();
        }
        return view('admin.walk_win_count.index',compact('alldata','access_type'));
    }

    
}
