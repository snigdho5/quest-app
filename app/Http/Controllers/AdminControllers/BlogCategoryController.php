<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\AdminModels\BlogCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogCategoryController extends Controller
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
        $data = BlogCategory::all();
        return view('admin.blog_category.index',compact('data','access_type'));
    }


    public function create()
    {
        abort_unless(in_array('add',$this->access_type), 403);
        return view('admin.blog_category.create');
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
        BlogCategory::create(request()->all());

        // set message and redirect
        session()->flash('success','Blog category added successfully.');
        return redirect()->route('admin::blogCategory');
    }

    public function edit($id, BlogCategory $blogCategory)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $blogCategory->find($id);
        return view('admin.blog_category.edit',compact('data'));
    }

    public function update($id, Request $request, BlogCategory $blogCategory)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'active' => 'required',
        ]);

        $blogCategory = $blogCategory->find($id);

        // update database
        $blogCategory->update(request()->all());
        $blogCategory->save();

        // set message and redirect
        session()->flash('success','Blog category updated successfully.');
        return redirect()->route('admin::blogCategory');
    }

    public function destroy($id, BlogCategory $blogCategory)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $blogCategory = $blogCategory->find($id);

        // delete data
        $blogCategory->delete();

        // set message and redirect
        session()->flash('success','Blog category deleted successfully.');
        return redirect()->route('admin::blogCategory');
    }

    public function change_status($id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        BlogCategory::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','Blog category status changed successfully.');
        return redirect()->route('admin::blogCategory');
    }
}
