<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\AdminModels\DineCuisine;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DineCuisineController extends Controller
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
        $data = DineCuisine::all();
        return view('admin.dine_cuisine.index',compact('data','access_type'));
    }


    public function create()
    {
        abort_unless(in_array('add',$this->access_type), 403);
        return view('admin.dine_cuisine.create');
    }

    public function store(Request $request)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'active' => 'required',
        ]);

        // insert into database
        DineCuisine::create(request()->all());

        // set message and redirect
        session()->flash('success','Dine cuisine added successfully.');
        return redirect()->route('admin::dineCuisine');
    }

    public function edit($id, DineCuisine $dineCuisine)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $dineCuisine->find($id);
        return view('admin.dine_cuisine.edit',compact('data'));
    }

    public function update($id, Request $request, DineCuisine $dineCuisine)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'active' => 'required',
        ]);

        $dineCuisine = $dineCuisine->find($id);

        // update database
        $dineCuisine->update(request()->all());
        $dineCuisine->save();

        // set message and redirect
        session()->flash('success','Dine cuisine updated successfully.');
        return redirect()->route('admin::dineCuisine');
    }

    public function destroy($id, DineCuisine $dineCuisine)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $dineCuisine = $dineCuisine->find($id);

        // delete data
        $dineCuisine->delete();

        // set message and redirect
        session()->flash('success','Dine cuisine deleted successfully.');
        return redirect()->route('admin::dineCuisine');
    }

    public function change_status($id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        DineCuisine::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','Dine cuisine status changed successfully.');
        return redirect()->route('admin::dineCuisine');
    }
}
