<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\AdminModels\AdminType;
use App\Models\AdminModels\AdminModule;
use Illuminate\Http\Request;

class AdminTypeController extends Controller
{
     public function __construct(){
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $data = AdminType::all();
        return view('admin.admin_type.index',compact('data'));
    }


    public function create()
    {
        $data = AdminModule::where([['active',1], ['link', '<>', '#']])->get();
        return view('admin.admin_type.create',compact('data'));
    }

    public function store(Request $request)
    {
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'module' => 'required|array|min:1',
            'module.*' => 'required',
            'access_type' => 'required|array|min:1',
            'access_type.*' => 'required',
            'active' => 'required'
        ]);
        request()->merge(['module' => implode(',',request()->module)]);
        request()->merge(['access_type' => implode(',',request()->access_type)]);

        // insert into database
        AdminType::create(request()->all());

        // set message and redirect
        session()->flash('success','Admin Type added successfully.');
        return redirect()->route('admin::type');
    }

    public function edit($id, AdminType $adminType)
    {
        $data = $adminType->find($id);
        $moduleData = AdminModule::where([['active',1], ['link', '<>', '#']])->get();
        return view('admin.admin_type.edit',compact('data','moduleData'));
    }

    public function update($id, Request $request, AdminType $adminType)
    {
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'module' => 'required|array|min:1',
            'module.*' => 'required',
            'access_type' => 'required|array|min:1',
            'access_type.*' => 'required',
            'active' => 'required'
        ]);
        request()->merge(['module' => implode(',',request()->module)]);
        request()->merge(['access_type' => implode(',',request()->access_type)]);

        $adminType = $adminType->find($id);
        // update database
        $adminType->update(request()->all());
        $adminType->save();

        // set message and redirect
        session()->flash('success','Admin Type updated successfully.');
        return redirect()->route('admin::type');
    }

    public function destroy($id, AdminType $adminType)
    {
        $adminType = $adminType->find($id);

        // delete data
        $adminType->delete();

        // set message and redirect
        session()->flash('success','Admin Type deleted successfully.');
        return redirect()->route('admin::type');
    }

    public function change_status($id,$type)
    {
        AdminType::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','Admin Type status changed successfully.');
        return redirect()->route('admin::type');
    }
}
