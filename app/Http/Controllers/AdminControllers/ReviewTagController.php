<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\AdminModels\ReviewTag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewTagController extends Controller
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
        $data = ReviewTag::all();
        return view('admin.review_tag.index',compact('data','access_type'));
    }


    public function create()
    {
        abort_unless(in_array('add',$this->access_type), 403);
        return view('admin.review_tag.create');
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
        ReviewTag::create(request()->all());

        // set message and redirect
        session()->flash('success','Tags added successfully.');
        return redirect()->route('admin::reviewTag');
    }

    public function edit($id, ReviewTag $reviewTag)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $reviewTag->find($id);
        return view('admin.review_tag.edit',compact('data'));
    }

    public function update($id, Request $request, ReviewTag $reviewTag)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'active' => 'required',
        ]);

        $reviewTag = $reviewTag->find($id);

        // update database
        $reviewTag->update(request()->all());
        $reviewTag->save();

        // set message and redirect
        session()->flash('success','Tags updated successfully.');
        return redirect()->route('admin::reviewTag');
    }

    public function destroy($id, ReviewTag $reviewTag)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $reviewTag = $reviewTag->find($id);

        // delete data
        $reviewTag->delete();

        // set message and redirect
        session()->flash('success','Tags deleted successfully.');
        return redirect()->route('admin::reviewTag');
    }

    public function change_status($id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        ReviewTag::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','Tags status changed successfully.');
        return redirect()->route('admin::reviewTag');
    }
}
