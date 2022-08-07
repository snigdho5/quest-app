<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AdminModels\TriviaContest;

class TriviaContestController extends Controller
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
        $date = date('Y-m-d',strtotime("+".((request('day')?request('day'):1)-1)."day",strtotime('2020-10-22')));

        $alldata = TriviaContest::whereDate('created_at', $date)->get();
        
        return view('admin.trivia_contest.index',compact('alldata','access_type'));
    }

    
}
