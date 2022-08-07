<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\AdminModels\FooterNavigation;
use Illuminate\Http\Request;

class FooterNavigationController extends Controller
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
        $data = FooterNavigation::all();
        return view('admin.footer_navigation.index',compact('data','access_type'));
    }


    public function create()
    {
        abort_unless(in_array('add',$this->access_type), 403);
        $data = FooterNavigation::where('parent_id',0)->get();
        return view('admin.footer_navigation.create',compact('data'));
    }

    public function store(Request $request)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'menu' => 'required',
            'parent_id' => 'required',
            'link' => 'required',
            'active' => 'required'
        ]);

        // ordering funtionality
        request()->merge(['priority' => FooterNavigation::where('parent_id',request('parent_id'))->count()+1]);

        // insert into database
        FooterNavigation::create(request()->all());

        // set message and redirect
        session()->flash('success','Navigation added successfully.');
        return redirect()->route('admin::footer_navigation');
    }

    public function edit($id, FooterNavigation $navigation)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $navigation->find($id);
        $allData = $navigation->where('parent_id',0)->get();
        return view('admin.footer_navigation.edit',compact('data','allData'));
    }

    public function update($id, Request $request, FooterNavigation $navigation)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'menu' => 'required',
            'parent_id' => 'required',
            'link' => 'required',
            'active' => 'required'
        ]);

        $navigation = $navigation->find($id);

        // fix ordering if moved to another parent
        if($navigation->parent_id != request()->parent_id){
            $old_parent = $navigation->parent_id;
            // update database
            $navigation->update(request()->all());
            $navigation->save();

            FooterNavigation::resetOrder($navigation->priority,$old_parent);
            request()->merge(['priority' => FooterNavigation::where('parent_id',request('parent_id'))->count()]);
            // update database
            $navigation->update(request()->all());
            $navigation->save();
        }else{
            // update database
            $navigation->update(request()->all());
            $navigation->save();
        }

        // set message and redirect
        session()->flash('success','Navigation updated successfully.');
        return redirect()->route('admin::footer_navigation');
    }

    public function destroy($id, FooterNavigation $navigation)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $navigation = $navigation->find($id);

        // reset priority
        FooterNavigation::resetOrder($navigation->priority,$navigation->parent_id);

        // delete data
        $navigation->delete();

        // set message and redirect
        session()->flash('success','Navigation deleted successfully.');
        return redirect()->route('admin::footer_navigation');
    }

    public function change_status($id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        FooterNavigation::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','Navigation status changed successfully.');
        return redirect()->route('admin::footer_navigation');
    }

    public function order(Request $request)
    {
        abort_unless(in_array('order',$this->access_type), 403);
        $oldOrder = intVal(FooterNavigation::find(request()->id)->priority);
        $parent_id = intVal(FooterNavigation::find(request()->id)->parent_id);
        $newOrder = intVal(request()->o);

        if($oldOrder < $newOrder)
            FooterNavigation::where([['parent_id', $parent_id],['priority','>', $oldOrder],['priority','<=', $newOrder]])->decrement('priority',1);
        else FooterNavigation::where([['parent_id', $parent_id],['priority','<', $oldOrder],['priority','>=', $newOrder]])->increment('priority',1);

        FooterNavigation::find(request()->id)->update(['priority'=>request()->o]);

        // set message and redirect
        session()->flash('success','Navigation order changed successfully.');
        return redirect()->route('admin::footer_navigation');
    }
}
