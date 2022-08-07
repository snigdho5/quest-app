<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\AdminModels\FashionPost;
use App\Models\AdminModels\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class FashionPostController extends Controller
{
    private $uploadPath = 'fashion_post/actual/';
    private $uploadPath_thumb = 'fashion_post/thumb/';
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
        $data = FashionPost::all();
        return view('admin.fashion_post.index',compact('data','access_type'));
    }


    public function create()
    {
        abort_unless(in_array('add',$this->access_type), 403);
        $store = Store::all();
        return view('admin.fashion_post.create',compact('store'));
    }

    public function store(Request $request)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        // validation
        $this->validate(request(),[
        	'store_id'  => 'required',
        	'title'  => 'required',
        	'imagefile'  => 'required|image|mimes:jpeg,jpg|max:4096',
        	'tag'  => 'required',
        	'link'  => 'required|url',
        	'post_time'  => 'required',
        	'active'  => 'required',
        ]);

        $image = request()->imagefile;
        $imagename = filterFileName($image);
        if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
            return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
        }else{
            image_crop($image, Storage::disk('public')->path($this->uploadPath_thumb.$imagename),400);
        }
        request()->merge(['image' => $imagename]);


        // insert into database
        FashionPost::create(request()->all());

        // set message and redirect
        session()->flash('success','Fashion Post added successfully.');
        return redirect()->route('admin::fashionPost');
    }

    public function edit($id, FashionPost $fashionPost)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $fashionPost->find($id);
        $store = Store::all();
        return view('admin.fashion_post.edit',compact('data','store'));
    }

    public function update($id, Request $request, FashionPost $fashionPost)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'store_id'  => 'required',
        	'title'  => 'required',
        	'imagefile'  => 'image|mimes:jpeg,jpg|max:4096',
        	'tag'  => 'required',
        	'link'  => 'required',
        	'post_time'  => 'required',
        	'active'  => 'required'
        ]);

        $fashionPost = $fashionPost->find($id);

        if (request()->hasFile('imagefile')) {
            $image = request()->imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
                return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
            }else{
                image_crop($image, Storage::disk('public')->path($this->uploadPath_thumb.$imagename),400);
            }
            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath.$fashionPost->image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$fashionPost->image);
            $old_file = Storage::disk('public')->path($this->uploadPath_thumb.$fashionPost->image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_thumb.$fashionPost->image);

            request()->merge(['image' => $imagename]);
        }

        // update database
        $fashionPost->update(request()->all());
        $fashionPost->save();

        // set message and redirect
        session()->flash('success','Fashion Post updated successfully.');
        return redirect()->route('admin::fashionPost');
    }

    public function destroy($id, FashionPost $fashionPost)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $fashionPost = $fashionPost->find($id);

        // delete file
        $old_file = Storage::disk('public')->path($this->uploadPath.$fashionPost->image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$fashionPost->image);

        $old_file = Storage::disk('public')->path($this->uploadPath_thumb.$fashionPost->image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_thumb.$fashionPost->image);

        // delete data
        $fashionPost->delete();

        // set message and redirect
        session()->flash('success','Fashion Post deleted successfully.');
        return redirect()->route('admin::fashionPost');
    }

    public function change_status($id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        FashionPost::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','Fashion Post status changed successfully.');
        return redirect()->route('admin::fashionPost');
    }
}
