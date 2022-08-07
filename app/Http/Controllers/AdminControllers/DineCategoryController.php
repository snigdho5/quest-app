<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\AdminModels\StoreCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DineCategoryController extends Controller
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
        $data = StoreCategory::where('type','dine')->get();
        return view('admin.dine_category.index',compact('data','access_type'));
    }


    public function create()
    {
        abort_unless(in_array('add',$this->access_type), 403);
        return view('admin.dine_category.create');
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
        StoreCategory::create(request()->all());

        // set message and redirect
        session()->flash('success','Dine category added successfully.');
        return redirect()->route('admin::dineCategory');
    }

    public function edit($id, StoreCategory $dineCategory)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $dineCategory->find($id);
        return view('admin.dine_category.edit',compact('data'));
    }

    public function update($id, Request $request, StoreCategory $dineCategory)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'active' => 'required',
        ]);

        $dineCategory = $dineCategory->find($id);

        // update database
        $dineCategory->update(request()->all());
        $dineCategory->save();

        // set message and redirect
        session()->flash('success','Dine category updated successfully.');
        return redirect()->route('admin::dineCategory');
    }

    public function destroy($id, StoreCategory $dineCategory)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $dineCategory = $dineCategory->find($id);

        // delete data
        $dineCategory->delete();

        // set message and redirect
        session()->flash('success','Dine category deleted successfully.');
        return redirect()->route('admin::dineCategory');
    }

    public function change_status($id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        StoreCategory::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','Dine category status changed successfully.');
        return redirect()->route('admin::dineCategory');
    }
}
