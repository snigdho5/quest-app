<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\AdminModels\Blog;
use App\Models\AdminModels\Store;
use App\Models\AdminModels\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;


class BlogController extends Controller
{
    private $uploadPath = 'blog/actual/';
    private $uploadPath_thumb = 'blog/thumb/';
    private $uploadPath_meta = 'link_data/';
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
        $data = Blog::all();
        return view('admin.blog.index',compact('data','access_type'));
    }


    public function create()
    {
        abort_unless(in_array('add',$this->access_type), 403);
        $store = Store::all();
        $category = BlogCategory::where('active','1')->get();
        return view('admin.blog.create',compact('store','category'));
    }

    public function store(Request $request)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'category_id' => 'required',
            'slug' => 'required|unique:blog,slug',
            'meta_imagefile' => 'image|mimes:jpeg,png,jpg|max:1024',
            'imagefile' => 'required|image|mimes:jpeg,png,jpg|max:4096',
            'sq_imagefile' => 'required|image|mimes:jpeg,png,jpg|max:4096',
            'content' => 'required',
            'store_id' => 'array',
            'post_time' => 'required',
            'active' => 'required',
        ]);

        if(request()->store_id) request()->merge(['store_id' => implode(',',request()->store_id)]);

        // fileupload
        $image = request()->imagefile;
        $imagename = filterFileName($image);
        if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
            return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
        }
        request()->merge(['image' => $imagename]);

        $image = request()->sq_imagefile;
        $imagename = filterFileName($image);
        if($image->storePubliclyAs($this->uploadPath_thumb, $imagename)==false){
            return back()->withErrors(['sq_imagefile'=>'Cannot upload to server.']);
        }
        request()->merge(['sq_image' => $imagename]);

        if (request()->hasFile('meta_imagefile')) {
            $image = request()->meta_imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath_meta, $imagename)==false){
                return back()->withErrors(['meta_imagefile'=>'Cannot upload to server.']);
            }
            request()->merge(['meta_image' => $imagename]);
        }

        // insert into database
        Blog::create(request()->all());

        // set message and redirect
        session()->flash('success','Blog post added successfully.');
        return redirect()->route('admin::blog');
    }

    public function edit($id, Blog $blog)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $blog->find($id);
        $store = Store::all();
        $category = BlogCategory::where('active','1')->get();
        return view('admin.blog.edit',compact('data','store','category'));
    }

    public function update($id, Request $request, Blog $blog)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'category_id' => 'required',
            'slug' => ['required',Rule::unique('blog')->ignore($id)],
            'content' => 'required',
            'imagefile' => 'image|mimes:jpeg,png,jpg|max:4096',
            'sq_imagefile' => 'image|mimes:jpeg,png,jpg|max:4096',
            'post_time' => 'required',
            'store_id' => 'array',
            'meta_imagefile' => 'image|mimes:jpeg,png,jpg|max:1024',
            'active' => 'required',
        ]);

        if(request()->store_id) request()->merge(['store_id' => implode(',',request()->store_id)]);

        $blog = $blog->find($id);

        // fileupload
        if (request()->hasFile('imagefile')) {
            $image = request()->imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
                return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
            }
            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath.$blog->image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$blog->image);

            request()->merge(['image' => $imagename]);
        }

        if (request()->hasFile('sq_imagefile')) {
            $image = request()->sq_imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath_thumb, $imagename)==false){
                return back()->withErrors(['sq_imagefile'=>'Cannot upload to server.']);
            }
            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath_thumb.$blog->sq_image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_thumb.$blog->sq_image);

            request()->merge(['sq_image' => $imagename]);
        }

        if (request()->hasFile('meta_imagefile')) {
            $image = request()->meta_imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath_meta, $imagename)==false){
                return back()->withErrors(['meta_imagefile'=>'Cannot upload to server.']);
            }
            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath_meta.$blog->meta_image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_meta.$blog->meta_image);

            request()->merge(['meta_image' => $imagename]);
        }

        // update database
        $blog->update(request()->all());
        $blog->save();

        // set message and redirect
        session()->flash('success','Blog post updated successfully.');
        return redirect()->route('admin::blog');
    }

    public function destroy($id, Blog $blog)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $blog = $blog->find($id);

        // delete file
        $old_file = Storage::disk('public')->path($this->uploadPath.$blog->image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$blog->image);
        $old_file = Storage::disk('public')->path($this->uploadPath_thumb.$blog->sq_image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_thumb.$blog->image);
        $old_file = Storage::disk('public')->path($this->uploadPath_meta.$blog->meta_image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_meta.$blog->meta_image);

        // delete data
        $blog->delete();

        // set message and redirect
        session()->flash('success','Blog post deleted successfully.');
        return redirect()->route('admin::blog');
    }

    public function change_status($id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        Blog::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','Blog post status changed successfully.');
        return redirect()->route('admin::blog');
    }

}
