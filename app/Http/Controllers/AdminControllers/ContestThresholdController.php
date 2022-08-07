<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\AdminModels\ContestThreshold;
use App\Models\AdminModels\Store;
use App\Models\AdminModels\ContestDine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class ContestThresholdController extends Controller
{
    private $uploadPath = 'contest_threshold/actual/';
    private $uploadPath_meta = 'link_data/';
    protected $access_type;

    public function __construct(){
        $this->middleware('auth:admin');
        $this->middleware(function ($request, $next) {
            $this->access_type = checkAccess(auth()->guard('admin')->user()->role);
            if(count($this->access_type)==0) abort(403);
            return $next($request);
        });
    }

    public function index($contest_id)
    {
        $access_type = $this->access_type;
        $data = ContestThreshold::where('contest_id',$contest_id)->get();
        return view('admin.contest_threshold.index',compact('data','access_type','contest_id'));
    }


    public function create($contest_id)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        $data = Store::where([['s_type','dine'],['active','1']])->get();
        return view('admin.contest_threshold.create',compact('data','contest_id'));
    }

    public function store($contest_id,Request $request)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        // validation

        $this->validate(request(),[
            'percentage' => 'required',
            'content' => 'required',
            'max_discount' => 'required',
            'min_trans' => 'required',
            'type' => 'required',
            'active' => 'required',
        ]);

        request()->merge(['contest_id' => $contest_id]);

        // insert into database
        $contest_threshold = ContestThreshold::create(request()->all());
        
        // set message and redirect
        session()->flash('success','ContestThreshold added successfully.');
        return redirect()->route('admin::threshold',$contest_id);
    }

    public function edit($contest_id,$id, ContestThreshold $contest_threshold)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $contest_threshold->find($id);
        return view('admin.contest_threshold.edit',compact('data','contest_id'));
    }

    public function update($contest_id,$id, Request $request, ContestThreshold $contest_threshold)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        // validation

        $contest_threshold = ContestThreshold::find($id);
        $this->validate(request(),[
            'percentage' => 'required',
            'content' => 'required',
            'max_discount' => 'required',
            'min_trans' => 'required',
            'type' => 'required',
            'active' => 'required',
        ]);
       
        // update database
        $contest_threshold->update(request()->all());
        $contest_threshold->save();

        // set message and redirect
        session()->flash('success','ContestThreshold updated successfully.');
        return redirect()->route('admin::threshold',$contest_id);

    }

    public function destroy($contest_id,$id, ContestThreshold $contest_threshold)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $contest_threshold = $contest_threshold->find($id);

        // delete data
        $contest_threshold->delete();

        // set message and redirect
        session()->flash('success','ContestThreshold deleted successfully.');
        return redirect()->route('admin::threshold',$contest_id);
    }

    public function change_status($contest_id,$id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        ContestThreshold::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','ContestThreshold status changed successfully.');
        return redirect()->route('admin::threshold',$contest_id);
    }
}
