<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\AdminModels\News;
use Illuminate\Http\Request;

class NewsController extends Controller
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
        $data = News::all();
        return view('admin.news.index',compact('data','access_type'));
    }


    public function create()
    {
        abort_unless(in_array('add',$this->access_type), 403);
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'link' => 'required',
            'post_time' => 'required',
            'active' => 'required',
        ]);

        // insert into database
        News::create(request()->all());

        // set message and redirect
        session()->flash('success','News added successfully.');
        return redirect()->route('admin::news');
    }

    public function edit($id, News $news)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $news->find($id);
        return view('admin.news.edit',compact('data'));
    }

    public function update($id, Request $request, News $news)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'link' => 'required',
            'post_time' => 'required',
            'active' => 'required',
        ]);

        $news = $news->find($id);

        // update database
        $news->update(request()->all());
        $news->save();

        // set message and redirect
        session()->flash('success','News updated successfully.');
        return redirect()->route('admin::news');
    }

    public function destroy($id, News $news)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $news = $news->find($id);

        // delete data
        $news->delete();

        // set message and redirect
        session()->flash('success','News deleted successfully.');
        return redirect()->route('admin::news');
    }

    public function change_status($id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        News::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','News status changed successfully.');
        return redirect()->route('admin::news');
    }
}
