<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\AdminModels\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class GalleryController extends Controller
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
        $data = Gallery::all();
        return view('admin.gallery.index',compact('data','access_type'));
    }


    public function create()
    {
        abort_unless(in_array('add',$this->access_type), 403);
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'date' => 'required',
            'active' => 'required',
        ]);

        // insert into database
        Gallery::create(request()->all());

        // set message and redirect
        session()->flash('success','Gallery added successfully.');
        return redirect()->route('admin::gallery');
    }

    public function edit($id, Gallery $gallery)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $gallery->find($id);
        return view('admin.gallery.edit',compact('data'));
    }

    public function update($id, Request $request, Gallery $gallery)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'date' => 'required',
            'active' => 'required',
        ]);

        $gallery = $gallery->find($id);

        // update database
        $gallery->update(request()->all());
        $gallery->save();

        // set message and redirect
        session()->flash('success','Gallery updated successfully.');
        return redirect()->route('admin::gallery');
    }

    public function destroy($id, Gallery $gallery)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $gallery = $gallery->find($id);


        // delete data
        $gallery->delete();

        // set message and redirect
        session()->flash('success','Gallery deleted successfully.');
        return redirect()->route('admin::gallery');
    }

    public function change_status($id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        Gallery::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','Gallery status changed successfully.');
        return redirect()->route('admin::gallery');
    }
}
