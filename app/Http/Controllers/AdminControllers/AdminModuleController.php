<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\AdminModels\AdminModule;
use Illuminate\Http\Request;

class AdminModuleController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $data = AdminModule::all();
        return view('admin.admin_module.index',compact('data'));
    }


    public function create()
    {
        $data = AdminModule::where('parent_id',0)->get();
        return view('admin.admin_module.create',compact('data'));
    }

    public function store(Request $request)
    {
        // validation
        $this->validate(request(),[
            'module' => 'required',
            'show_menu' => 'required',
            'parent_id' => 'required',
            'link' => 'required',
            'access_type' => 'array',
            'active' => 'required'
        ]);
        if(request()->access_type) request()->merge(['access_type' => implode(',',request()->access_type)]);

        // ordering funtionality
        request()->merge(['priority' => AdminModule::where('parent_id',request('parent_id'))->count()+1]);

        // insert into database
        AdminModule::create(request()->all());

        // set message and redirect
        session()->flash('success','Module added successfully.');
        return redirect()->route('admin::module');
    }

    public function edit($id, AdminModule $adminModule)
    {
        $data = $adminModule->find($id);
        $allData = $adminModule->where('parent_id',0)->get();
        return view('admin.admin_module.edit',compact('data','allData'));
    }

    public function update($id, Request $request, AdminModule $adminModule)
    {
        // validation
        $this->validate(request(),[
            'module' => 'required',
            'show_menu' => 'required',
            'parent_id' => 'required',
            'link' => 'required',
            'access_type' => 'array',
            'access_type.*' => 'required',
            'active' => 'required'
        ]);
        if(request()->access_type) request()->merge(['access_type' => implode(',',request()->access_type)]);

        $adminModule = $adminModule->find($id);


        // fix ordering if moved to another parent
        if($adminModule->parent_id != request()->parent_id){
            $old_parent = $adminModule->parent_id;
            // update database
            $adminModule->update(request()->all());
            $adminModule->save();

            AdminModule::resetOrder($adminModule->priority,$old_parent);
            request()->merge(['priority' => AdminModule::where('parent_id',request('parent_id'))->count()]);
            // update database
            $adminModule->update(request()->all());
            $adminModule->save();
        }else{
            // update database
            $adminModule->update(request()->all());
            $adminModule->save();
        }


        // set message and redirect
        session()->flash('success','Module updated successfully.');
        return redirect()->route('admin::module');
    }

    public function destroy($id, AdminModule $adminModule)
    {
        $adminModule = $adminModule->find($id);

        // reset priority
        AdminModule::resetOrder($adminModule->priority,$adminModule->parent_id);

        // delete data
        $adminModule->delete();

        // set message and redirect
        session()->flash('success','Module deleted successfully.');
        return redirect()->route('admin::module');
    }

    public function change_status($id,$type)
    {
        AdminModule::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','Module status changed successfully.');
        return redirect()->route('admin::module');
    }

    public function order(Request $request)
    {
        $oldOrder = intVal(AdminModule::find(request()->id)->priority);
        $parent_id = intVal(AdminModule::find(request()->id)->parent_id);
        $newOrder = intVal(request()->o);

        if($oldOrder < $newOrder)
            AdminModule::where([['parent_id', $parent_id],['priority','>', $oldOrder],['priority','<=', $newOrder]])->decrement('priority',1);
        else AdminModule::where([['parent_id', $parent_id],['priority','<', $oldOrder],['priority','>=', $newOrder]])->increment('priority',1);

        AdminModule::find(request()->id)->update(['priority'=>request()->o]);

        // set message and redirect
        session()->flash('success','Module order changed successfully.');
        return redirect()->route('admin::module');
    }
}
