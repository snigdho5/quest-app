<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\AdminModels\StoreType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StoreTypeController extends Controller
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
        $data = StoreType::where('type','store')->get();
        return view('admin.store_type.index',compact('data','access_type'));
    }


    public function create()
    {
        abort_unless(in_array('add',$this->access_type), 403);
        return view('admin.store_type.create');
    }

    public function store(Request $request)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'active' => 'required',
        ]);
        request()->merge(['type' => 'store']);

        // insert into database
        StoreType::create(request()->all());

        // set message and redirect
        session()->flash('success','Store type added successfully.');
        return redirect()->route('admin::storeType');
    }

    public function edit($id, StoreType $storeType)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $storeType->find($id);
        return view('admin.store_type.edit',compact('data'));
    }

    public function update($id, Request $request, StoreType $storeType)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'active' => 'required',
        ]);

        $storeType = $storeType->find($id);

        // update database
        $storeType->update(request()->all());
        $storeType->save();

        // set message and redirect
        session()->flash('success','Store type updated successfully.');
        return redirect()->route('admin::storeType');
    }

    public function destroy($id, StoreType $storeType)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $storeType = $storeType->find($id);

        // delete data
        $storeType->delete();

        // set message and redirect
        session()->flash('success','Store type deleted successfully.');
        return redirect()->route('admin::storeType');
    }

    public function change_status($id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        StoreType::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','Store type status changed successfully.');
        return redirect()->route('admin::storeType');
    }
}
