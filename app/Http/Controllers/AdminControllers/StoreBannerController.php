<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\AdminModels\StoreBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class StoreBannerController extends Controller
{
    private $uploadPath = 'store_banner/actual/';
    private $uploadPath_thumb = 'store_banner/thumb/';
    private $uploadPath_app = 'store_banner/app/';
    protected $access_type;

    public function __construct(){
        $this->middleware('auth:admin');
        $this->middleware(function ($request, $next) {
            $this->access_type = checkAccess(auth()->guard('admin')->user()->role);
            if(count($this->access_type)==0) abort(403);
            return $next($request);
        });
    }

    public function index($store_id)
    {
        $access_type = $this->access_type;
        $data = StoreBanner::where('store_id',$store_id)->get();
        return view('admin.store_banner.index',compact('data','access_type', 'store_id'));
    }


    public function create($store_id)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        return view('admin.store_banner.create',compact('store_id'));
    }

    public function store($store_id, Request $request)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'featured' => 'required',
            'imagefile' => 'required|image|mimes:jpeg,jpg|max:4096',
            'aimagefile' => 'required|image|mimes:jpeg,jpg|max:4096',
            'active' => 'required',
        ]);

        request()->merge(['store_id' => $store_id]);

        // ordering funtionality
        request()->merge(['priority' => StoreBanner::where('store_id',request('store_id'))->count()+1]);

        $image = request()->imagefile;
        $imagename = filterFileName($image);
        if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
            return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
        }else{
            image_crop($image, Storage::disk('public')->path($this->uploadPath_thumb.$imagename),500);
        }
        request()->merge(['image' => $imagename]);

        $aimage = request()->aimagefile;
        $aimagename = filterFileName($aimage);
        if($aimage->storePubliclyAs($this->uploadPath_app, $aimagename)==false){
            return back()->withErrors(['aimagefile'=>'Cannot upload to server.']);
        }
        request()->merge(['app_image' => $aimagename]);


        // insert into database
        $data = StoreBanner::create(request()->all());

        //reset all featured image
        if(request()->featured == '1') StoreBanner::where([['id','!=', $data->id],['store_id',$store_id]])->update(array('featured'=>0));

        // set message and redirect
        session()->flash('success','Store Banner added successfully.');
        return redirect()->route('admin::storeBanner',$store_id);
    }

    public function edit($store_id, $id, StoreBanner $storeBanner)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $storeBanner->find($id);
        return view('admin.store_banner.edit',compact('data','store_id'));
    }

    public function update($store_id, $id, Request $request, StoreBanner $storeBanner)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'featured' => 'required',
            'imagefile' => 'image|mimes:jpeg,jpg|max:4096',
            'aimagefile' => 'image|mimes:jpeg,jpg|max:4096',
            'active' => 'required',
        ]);

        $storeBanner = $storeBanner->find($id);

        if (request()->hasFile('imagefile')) {
            $image = request()->imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
                return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
            }else{
                image_crop($image, Storage::disk('public')->path($this->uploadPath_thumb.$imagename),500);
            }
            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath.$storeBanner->image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$storeBanner->image);
            $old_file = Storage::disk('public')->path($this->uploadPath_thumb.$storeBanner->image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_thumb.$storeBanner->image);

            request()->merge(['image' => $imagename]);
        }
        if (request()->hasFile('aimagefile')) {
            $aimage = request()->aimagefile;
            $aimagename = filterFileName($aimage);
            if($aimage->storePubliclyAs($this->uploadPath_app, $aimagename)==false){
                return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
            }
            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath_app.$storeBanner->app_image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_app.$storeBanner->app_image);

            request()->merge(['app_image' => $aimagename]);
        }

        // update database
        $storeBanner->update(request()->all());
        $storeBanner->save();

        //reset all featured image
        if(request()->featured == '1') StoreBanner::where([['id','!=', $id],['store_id',$store_id]])->update(array('featured'=>0));

        // set message and redirect
        session()->flash('success','Store Banner updated successfully.');
        return redirect()->route('admin::storeBanner',$store_id);
    }

    public function destroy($store_id, $id, StoreBanner $storeBanner)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $storeBanner = $storeBanner->find($id);

        // delete file
        $old_file = Storage::disk('public')->path($this->uploadPath.$storeBanner->image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$storeBanner->image);
        $old_file = Storage::disk('public')->path($this->uploadPath_thumb.$storeBanner->image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_thumb.$storeBanner->image);
        $old_file = Storage::disk('public')->path($this->uploadPath_app.$storeBanner->app_image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_app.$storeBanner->app_image);

        // reset priority
        StoreBanner::resetOrder($storeBanner->priority,$storeBanner->store_id);

        // delete data
        $storeBanner->delete();

        // set message and redirect
        session()->flash('success','Store Banner deleted successfully.');
        return redirect()->route('admin::storeBanner',$store_id);
    }

    public function change_status($store_id, $id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        StoreBanner::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','Store Banner status changed successfully.');
        return redirect()->route('admin::storeBanner',$store_id);
    }

    public function order($store_id, Request $request)
    {
        abort_unless(in_array('order',$this->access_type), 403);
        $oldOrder = intVal(StoreBanner::find(request()->id)->priority);
        $store_id = intVal(StoreBanner::find(request()->id)->store_id);
        $newOrder = intVal(request()->o);

        if($oldOrder < $newOrder)
            StoreBanner::where([['store_id', $store_id],['priority','>', $oldOrder],['priority','<=', $newOrder]])->decrement('priority',1);
        else StoreBanner::where([['store_id', $store_id],['priority','<', $oldOrder],['priority','>=', $newOrder]])->increment('priority',1);

        StoreBanner::find(request()->id)->update(['priority'=>request()->o]);

        // set message and redirect
        session()->flash('success','Banner order changed successfully.');
        return redirect()->route('admin::storeBanner',$store_id);
    }
}
