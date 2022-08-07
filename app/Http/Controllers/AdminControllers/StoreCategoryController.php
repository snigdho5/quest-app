<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\AdminModels\StoreCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StoreCategoryController extends Controller
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
        $data = StoreCategory::where('type','store')->get();
        return view('admin.store_category.index',compact('data','access_type'));
    }


    public function create()
    {
        abort_unless(in_array('add',$this->access_type), 403);
        return view('admin.store_category.create');
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
        StoreCategory::create(request()->all());

        // set message and redirect
        session()->flash('success','Store category added successfully.');
        return redirect()->route('admin::storeCategory');
    }

    public function edit($id, StoreCategory $storeCategory)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $storeCategory->find($id);
        return view('admin.store_category.edit',compact('data'));
    }

    public function update($id, Request $request, StoreCategory $storeCategory)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'active' => 'required',
        ]);

        $storeCategory = $storeCategory->find($id);

        // update database
        $storeCategory->update(request()->all());
        $storeCategory->save();

        // set message and redirect
        session()->flash('success','Store category updated successfully.');
        return redirect()->route('admin::storeCategory');
    }

    public function destroy($id, StoreCategory $storeCategory)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $storeCategory = $storeCategory->find($id);

        // delete data
        $storeCategory->delete();

        // set message and redirect
        session()->flash('success','Store category deleted successfully.');
        return redirect()->route('admin::storeCategory');
    }

    public function change_status($id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        StoreCategory::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','Store category status changed successfully.');
        return redirect()->route('admin::storeCategory');
    }
}
