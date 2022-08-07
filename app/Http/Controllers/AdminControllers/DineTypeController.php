<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\AdminModels\StoreType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DineTypeController extends Controller
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
        $data = StoreType::where('type','dine')->get();
        return view('admin.dine_type.index',compact('data','access_type'));
    }


    public function create()
    {
        abort_unless(in_array('add',$this->access_type), 403);
        return view('admin.dine_type.create');
    }

    public function store(Request $request)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'active' => 'required',
        ]);
        request()->merge(['type' => 'dine']);

        // insert into database
        StoreType::create(request()->all());

        // set message and redirect
        session()->flash('success','Dine type added successfully.');
        return redirect()->route('admin::dineType');
    }

    public function edit($id, StoreType $dineType)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $dineType->find($id);
        return view('admin.dine_type.edit',compact('data'));
    }

    public function update($id, Request $request, StoreType $dineType)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'active' => 'required',
        ]);

        $dineType = $dineType->find($id);

        // update database
        $dineType->update(request()->all());
        $dineType->save();

        // set message and redirect
        session()->flash('success','Dine type updated successfully.');
        return redirect()->route('admin::dineType');
    }

    public function destroy($id, StoreType $dineType)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $dineType = $dineType->find($id);

        // delete data
        $dineType->delete();

        // set message and redirect
        session()->flash('success','Dine type deleted successfully.');
        return redirect()->route('admin::dineType');
    }

    public function change_status($id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        StoreType::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','Dine type status changed successfully.');
        return redirect()->route('admin::dineType');
    }
}
