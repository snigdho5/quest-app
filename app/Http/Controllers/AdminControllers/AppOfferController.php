<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\AdminModels\StoreAppDeal;
use App\Models\AdminModels\StoreAppDealDayTime;
use App\Models\AdminModels\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class AppOfferController extends Controller
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
        // $this->testNotification();
        $access_type = $this->access_type;
        $data = StoreAppDeal::all();
        return view('admin.app_offer.index',compact('data','access_type'));
    }


    public function create()
    {
        abort_unless(in_array('add',$this->access_type), 403);
        $store = Store::select('name','id')->where('active','1')->orderBy('name','asc')->get();
        return view('admin.app_offer.create',compact('store'));
    }

    public function store(Request $request)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'store_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'active' => 'required',
            'activeday' => 'required|array',
            'activeday.*' => 'required',
            'fromtime' => 'required|array',
            'fromtime.*' => 'required|date_format:h:i a',
            'totime' => 'required|array',
            'totime.*' => 'required|date_format:h:i a',
        ]);

        // insert into database
        $app_offer = StoreAppDeal::create(request()->all());

        foreach ($request->activeday as $key => $value) {
            StoreAppDealDayTime::create(['offer_id'=>$app_offer->id,'day'=>$value, 'fromtime'=>$request->fromtime[$key], 'totime'=>$request->totime[$key]]);
        }

        // set message and redirect
        session()->flash('success','App exclusive offer added successfully.');
        return redirect()->route('admin::appOffer');
    }

    public function edit($id, StoreAppDeal $app_offer)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $app_offer->find($id);
        $store = Store::select('name','id')->where('active','1')->orderBy('name','asc')->get();
        return view('admin.app_offer.edit',compact('data','store'));
    }

    public function update($id, Request $request, StoreAppDeal $app_offer)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'store_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'active' => 'required',
            'activeday' => 'required|array',
            'activeday.*' => 'required',
            'fromtime' => 'required|array',
            'fromtime.*' => 'required|date_format:h:i a',
            'totime' => 'required|array',
            'totime.*' => 'required|date_format:h:i a',
        ]);

        $app_offer = $app_offer->find($id);

        // update database
        $app_offer->update(request()->all());
        $app_offer->save();

        StoreAppDealDayTime::where('offer_id',$id)->delete();
        foreach ($request->activeday as $key => $value) {
            StoreAppDealDayTime::create(['offer_id'=>$app_offer->id,'day'=>$value, 'fromtime'=>$request->fromtime[$key], 'totime'=>$request->totime[$key]]);
        }

        // set message and redirect
        session()->flash('success','App exclusive offer updated successfully.');
        return redirect()->route('admin::appOffer');
    }

    public function destroy($id, StoreAppDeal $app_offer)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $app_offer = $app_offer->find($id);
        StoreAppDealDayTime::where('offer_id',$id)->delete();
	    $app_offer->delete();
        return redirect()->route('admin::appOffer');
    }

    public function change_status($id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        StoreAppDeal::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','App exclusive offer status changed successfully.');
        return redirect()->route('admin::appOffer');
    }
}