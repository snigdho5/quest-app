<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\AdminModels\Admin;
use App\Models\AdminModels\AdminType;
use Illuminate\Http\Request;

class AdminManageController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $data = Admin::all();
        return view('admin.admin_manage.index',compact('data'));
    }


    public function create()
    {
        $data = AdminType::where('active',1)->get();
        return view('admin.admin_manage.create',compact('data'));
    }

    public function store(Request $request)
    {
        // validation
        $this->validate(request(),[
            'name' => 'required',
            'password' => 'required',
            'username' => 'required|unique:admin,username',
            'role' => 'required',
            'active' => 'required'
        ]);

        // ordering funtionality
        request()->merge(['password' => bcrypt(request('password'))]);

        // insert into database
        Admin::create(request()->all());

        // set message and redirect
        session()->flash('success','Admin added successfully.');
        return redirect()->route('admin::manage');
    }

    public function edit($id, Admin $admin)
    {
        $data = $admin->find($id);
        $roleData = AdminType::where('active',1)->get();
        return view('admin.admin_manage.edit',compact('data','roleData'));
    }

    public function update($id, Request $request, Admin $admin)
    {
        // validation
        $this->validate(request(),[
            'name' => 'required',
            'username' => 'required|unique:admin,username,'.$id,
            'role' => 'required',
            'active' => 'required'
        ]);

        $admin = $admin->find($id);

        if(request('password')=='') request()->merge(['password' => $admin->password]);
        else request()->merge(['password' => bcrypt(request('password'))]);

        // update database
        $admin->update(request()->all());
        $admin->save();

        // set message and redirect
        session()->flash('success','Admin updated successfully.');
        return redirect()->route('admin::manage');
    }

    public function destroy($id, Admin $admin)
    {
        $admin = $admin->find($id);

        // delete data
        $admin->delete();

        // set message and redirect
        session()->flash('success','Admin deleted successfully.');
        return redirect()->route('admin::manage');
    }

    public function change_status($id,$type)
    {
        Admin::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','Admin status changed successfully.');
        return redirect()->route('admin::manage');
    }


}
