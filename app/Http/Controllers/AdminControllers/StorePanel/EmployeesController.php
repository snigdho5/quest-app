<?php

namespace App\Http\Controllers\AdminControllers\StorePanel;

use App\Models\AdminModels\StoreStaff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EmployeesController extends Controller
{

    public function __construct(){
        if(\Session::has('store_id') == false) return redirect()->route('admin::storePanel::logout');
    }

    public function index(Request $request)
    {
         $store_id=$request->session()->get('store_id');
       
         //$data = DB::table('qst_store_staff')->where('store_id',129)->get();
          $data = StoreStaff::where('store_id',$store_id)->get();
         //$data = StoreStaff::all();
        return view('admin.storepanel.employees.index',compact('data'));
    }


    public function create()
    {
        return view('admin.storepanel.employees.create');
    }

    public function store(Request $request)
    {
        
        // validation
        $this->validate(request(),[
            'name' => 'required',
            'phone' => 'required|unique:store_staff,phone',
            'active' => 'required',
        ]);

        // insert into database
        StoreStaff::create(request()->all());

        // set message and redirect
        session()->flash('success','Employee added successfully.');
        return redirect()->route('admin::storePanel::employees');
    }

    public function edit($id, StoreStaff $staff)
    {
        
        $data = $staff->find($id);
        
        return view('admin.storepanel.employees.edit',compact('data'));
    }

    public function update($id, Request $request, StoreStaff $staff)
    {
        
        // validation
        $this->validate(request(),[
            'name' => 'required',
            'phone' => 'required|unique:store_staff,phone,'.$id,
            'active' => 'required',
        ]);

        $staff = $staff->find($id);

        // update database
        $staff->update(request()->all());
        $staff->save();

        // set message and redirect
        session()->flash('success','Employee updated successfully.');
        return redirect()->route('admin::storePanel::employees');
    }

    public function destroy($id, StoreStaff $staff)
    {   
        $staff = $staff->find($id);
        $staff->delete();

        session()->flash('success','Employee deleted successfully.');
        return redirect()->route('admin::storePanel::employees');
    }

    public function change_status($id,$type)
    {
        StoreStaff::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','Employee status changed successfully.');
        return redirect()->route('admin::storePanel::employees');
    }

}
