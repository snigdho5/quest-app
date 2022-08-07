<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\AdminModels\Cms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;


class CmsController extends Controller
{
    private $uploadPath = 'cms/actual/';
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
        $data = Cms::all();
        return view('admin.cms.index',compact('data','access_type'));
    }


    public function create()
    {
        abort_unless(in_array('add',$this->access_type), 403);
        return view('admin.cms.create');
    }

    public function store(Request $request)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'slug' => 'required|unique:cms,slug',
            'meta_imagefile' => 'image|mimes:jpeg,png,jpg|max:1024',
            // 'short_content' => 'required',
            'content' => 'required',
            'post_time' => 'required',
            'imagefile' => 'required_if:header,1|image|mimes:jpeg,png,jpg|max:4096',
            'active' => 'required',
            'header' => 'required',
        ]);

        // fileupload
        if (request()->header == '1') {
            $image = request()->imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
                return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
            }
            request()->merge(['image' => $imagename]);
        }

        if (request()->hasFile('meta_imagefile')) {
            $image = request()->meta_imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath_meta, $imagename)==false){
                return back()->withErrors(['meta_imagefile'=>'Cannot upload to server.']);
            }
            request()->merge(['meta_image' => $imagename]);
        }

        // insert into database
        Cms::create(request()->all());

        // set message and redirect
        session()->flash('success','Custom Page added successfully.');
        return redirect()->route('admin::cms');
    }

    public function edit($id, Cms $cms)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $cms->find($id);
        return view('admin.cms.edit',compact('data'));
    }

    public function update($id, Request $request, Cms $cms)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'slug' => ['required',Rule::unique('cms')->ignore($id)],
            // 'short_content' => 'required',
            'content' => 'required',
            'imagefile' => 'image|mimes:jpeg,png,jpg|max:4096',
            'post_time' => 'required',
            'meta_imagefile' => 'image|mimes:jpeg,png,jpg|max:1024',
            'active' => 'required',
            'header' => 'required',
        ]);

        $cms = $cms->find($id);

        if (request()->header == '0' && $cms->image!= '') {
            $old_file = Storage::disk('public')->path($this->uploadPath.$cms->image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$cms->image);
            request()->merge(['image' => '']);
        }
        // fileupload
        if (request()->hasFile('imagefile')) {
            $image = request()->imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
                return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
            }
            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath.$cms->image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$cms->image);

            request()->merge(['image' => $imagename]);
        }


        if (request()->hasFile('meta_imagefile')) {
            $image = request()->meta_imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath_meta, $imagename)==false){
                return back()->withErrors(['meta_imagefile'=>'Cannot upload to server.']);
            }
            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath_meta.$cms->meta_image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_meta.$cms->meta_image);

            request()->merge(['meta_image' => $imagename]);
        }

        // update database
        $cms->update(request()->all());
        $cms->save();

        // set message and redirect
        session()->flash('success','Custom Page updated successfully.');
        return redirect()->route('admin::cms');
    }

    public function destroy($id, Cms $cms)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $cms = $cms->find($id);

        // delete file
        $old_file = Storage::disk('public')->path($this->uploadPath.$cms->image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$cms->image);
        $old_file = Storage::disk('public')->path($this->uploadPath_meta.$cms->meta_image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_meta.$cms->meta_image);

        // delete data
        $cms->delete();

        // set message and redirect
        session()->flash('success','Custom Page deleted successfully.');
        return redirect()->route('admin::cms');
    }

    public function change_status($id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        Cms::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','Custom Page status changed successfully.');
        return redirect()->route('admin::cms');
    }

}
