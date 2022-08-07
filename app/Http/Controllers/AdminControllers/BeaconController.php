<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\AdminModels\Beacon;
use App\Models\AdminModels\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BeaconController extends Controller
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
        $data = Beacon::all();
        return view('admin.beacon.index',compact('data','access_type'));
    }


    public function create()
    {
        abort_unless(in_array('add',$this->access_type), 403);
        $store = Store::all();
        return view('admin.beacon.create',compact('store'));
    }

    public function store(Request $request)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'uuid'  => 'required',
            'mac'  => 'required',
            'type'  => 'required',
            'place'  => 'required_if:type,1',
        	'store'  => 'required_if:type,0',
        ]);

        // insert into database
        $data = Beacon::create(request()->all());

        if(request()->type == "0"){
            Store::whereIn('id',request()->store)->update(['beacon_id'=>$data->id]);
        }

        // set message and redirect
        session()->flash('success','Beacon added successfully.');
        return redirect()->route('admin::beacon');
    }

    public function edit($id, Beacon $beacon)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $beacon->find($id);
        $store = Store::all();
        return view('admin.beacon.edit',compact('data','store'));
    }

    public function update($id, Request $request, Beacon $beacon)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'uuid'  => 'required',
            'mac'  => 'required',
            'type'  => 'required',
            'place'  => 'required',
            'place'  => 'required_if:type,1',
            'store'  => 'required_if:type,0',
        ]);

        $beacon = $beacon->find($id);

        // update database
        $beacon->update(request()->all());
        $beacon->save();

        Store::where('beacon_id',$beacon->id)->update(['beacon_id'=>0]);
        if(request()->type == "0"){
            Store::whereIn('id',request()->store)->update(['beacon_id'=>$beacon->id]);
        }

        // set message and redirect
        session()->flash('success','Beacon updated successfully.');
        return redirect()->route('admin::beacon');
    }

    public function destroy($id, Beacon $beacon)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $beacon = $beacon->find($id);

        Store::whereIn('beacon_id',$beacon->id)->update('beacon_id',0);

        // delete data
        $beacon->delete();

        // set message and redirect
        session()->flash('success','Beacon deleted successfully.');
        return redirect()->route('admin::beacon');
    }
}
