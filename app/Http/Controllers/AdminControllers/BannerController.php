<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\AdminModels\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class BannerController extends Controller
{
    private $uploadPath = 'banner/actual/';
    private $uploadPath_thumb = 'banner/thumb/';
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
        $data = Banner::all();
        return view('admin.banner.index',compact('data','access_type'));
    }


    public function create()
    {
        abort_unless(in_array('add',$this->access_type), 403);
        return view('admin.banner.create');
    }

    public function store(Request $request)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'imagefile' => 'required|image|mimes:jpeg,png,jpg|max:4096',
            'sq_imagefile' => 'required|image|mimes:jpeg,png,jpg|max:4096|dimensions:ratio=1',
            'post_time' => 'required',
            'link' =>  'required',
            'link_open' =>  'required',
            'active' => 'required',
        ]);

        // ordering funtionality
        request()->merge(['priority' => Banner::count()+1]);

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


        // insert into database
        Banner::create(request()->all());

        // set message and redirect
        session()->flash('success','Banner added successfully.');
        return redirect()->route('admin::banner');
    }

    public function edit($id, Banner $banner)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $banner->find($id);
        return view('admin.banner.edit',compact('data'));
    }

    public function update($id, Request $request, Banner $banner)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'imagefile' => 'image|mimes:jpeg,jpg|max:4096',
            'sq_imagefile' => 'image|mimes:jpeg,png,jpg|max:4096|dimensions:ratio=1',
            'post_time' => 'required',
            'link' => 'required',
            'link_open' =>  'required',
            'active' => 'required',
        ]);

        $banner = $banner->find($id);

        if (request()->hasFile('imagefile')) {
            $image = request()->imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
                return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
            }
            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath.$banner->image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$banner->image);

            request()->merge(['image' => $imagename]);
        }
        if (request()->hasFile('sq_imagefile')) {
            $image = request()->sq_imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath_thumb, $imagename)==false){
                return back()->withErrors(['sq_imagefile'=>'Cannot upload to server.']);
            }
            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath_thumb.$banner->sq_image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_thumb.$banner->sq_image);

            request()->merge(['sq_image' => $imagename]);
        }

        // update database
        $banner->update(request()->all());
        $banner->save();

        // set message and redirect
        session()->flash('success','Banner updated successfully.');
        return redirect()->route('admin::banner');
    }

    public function destroy($id, Banner $banner)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $banner = $banner->find($id);

        // delete file
        $old_file = Storage::disk('public')->path($this->uploadPath.$banner->image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$banner->image);

        $old_file = Storage::disk('public')->path($this->uploadPath_thumb.$banner->sq_image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_thumb.$banner->sq_image);

        // reset priority
        Banner::resetOrder($banner->priority);

        // delete data
        $banner->delete();

        // set message and redirect
        session()->flash('success','Banner deleted successfully.');
        return redirect()->route('admin::banner');
    }

    public function change_status($id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        Banner::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','Banner status changed successfully.');
        return redirect()->route('admin::banner');
    }

    public function order(Request $request)
    {
        abort_unless(in_array('order',$this->access_type), 403);
        $oldOrder = intVal(Banner::find(request()->id)->priority);
        $newOrder = intVal(request()->o);

        if($oldOrder < $newOrder)
            Banner::where([['priority','>', $oldOrder],['priority','<=', $newOrder]])->decrement('priority',1);
        else Banner::where([['priority','<', $oldOrder],['priority','>=', $newOrder]])->increment('priority',1);

        Banner::find(request()->id)->update(['priority'=>request()->o]);

        // set message and redirect
        session()->flash('success','Banner order changed successfully.');
        return redirect()->route('admin::banner');
    }
}
