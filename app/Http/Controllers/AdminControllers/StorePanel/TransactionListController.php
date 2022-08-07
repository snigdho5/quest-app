<?php

namespace App\Http\Controllers\AdminControllers\StorePanel;

use App\Models\AdminModels\StoreAppDealClaimed;
use App\Models\AdminModels\Store;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CustomLibrary\CaptchaController;

class TransactionListController extends Controller
{
    public function __construct(){
        if(\Session::has('store_id') == false) return redirect()->route('admin::storePanel::logout');
    }

    public function index()
    {
        $data = StoreAppDealClaimed::where('store_id', \Session::get('store_id'))->where('claimed',1);

        if(request('start_date')){
            $start_date = request('start_date');
            $end_date   = request('end_date');
        }else{
            $start_date = date('Y-m-d',strtotime('-5days'));
            $end_date   = date('Y-m-d');
        }
        $start = $start_date.' 00:00:00';
        $end   = $end_date.' 23:59:59';

        $data = $data->whereBetween('updated_at', [$start, $end])->orderBy('updated_at','desc')->get();
        return view('admin.storepanel.transaction',compact('data','start_date','end_date'));
    }
}
