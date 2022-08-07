<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminModels\UserWalkOffer;

class WalkWinOfferRedeemController extends Controller
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
            $start = request('start_date').' 00:00:00';
            $end   = request('end_date').' 23:59:59';

            $data = UserWalkOffer::whereBetween('redeem_date', [$start, $end])->get();
        }else{
            $data = UserWalkOffer::all();
        }
        return view('admin.walk_win_offer_redeem.index',compact('data','access_type'));
    }

    
}
