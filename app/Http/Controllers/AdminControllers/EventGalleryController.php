<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\AdminModels\LoftDesigner;
use App\Models\AdminModels\EventGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class EventGalleryController extends Controller
{
    private $uploadPath = 'event_gallery/actual/';
    private $uploadPath_thumb = 'event_gallery/thumb/';
    protected $access_type;

    public function __construct(){
        $this->middleware('auth:admin');
        $this->middleware(function ($request, $next) {
            $this->access_type = checkAccess(auth()->guard('admin')->user()->role);
            if(count($this->access_type)==0) abort(403);
            return $next($request);
        });
    }

    public function index($event_id)
    {
        $access_type = $this->access_type;
        $data = EventGallery::where('event_id',$event_id)->get();
        return view('admin.event_gallery.index',compact('data','access_type', 'event_id'));
    }


    public function create($event_id)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        $designer = LoftDesigner::all();
        return view('admin.event_gallery.create',compact('event_id','designer'));
    }

    public function store($event_id, Request $request)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'imagefile' => 'required|image|mimes:jpeg,jpg|max:4096',
            'active' => 'required',
        ]);

        request()->merge(['event_id' => $event_id]);

        $image = request()->imagefile;
        $imagename = filterFileName($image);
        if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
            return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
        }else{
            image_crop($image, Storage::disk('public')->path($this->uploadPath_thumb.$imagename),500);
        }
        request()->merge(['image' => $imagename]);


        // insert into database
        EventGallery::create(request()->all());

        // set message and redirect
        session()->flash('success','Event gallery added successfully.');
        return redirect()->route('admin::eventGallery',$event_id);
    }

    public function edit($event_id, $id, EventGallery $eventGallery)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $eventGallery->find($id);
        $designer = LoftDesigner::all();
        return view('admin.event_gallery.edit',compact('data','event_id','designer'));
    }

    public function update($event_id, $id, Request $request, EventGallery $eventGallery)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'imagefile' => 'image|mimes:jpeg,jpg|max:4096',
            'active' => 'required',
        ]);

        $eventGallery = $eventGallery->find($id);

        if (request()->hasFile('imagefile')) {
            $image = request()->imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
                return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
            }else{
                image_crop($image, Storage::disk('public')->path($this->uploadPath_thumb.$imagename),500);
            }
            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath.$eventGallery->image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$eventGallery->image);
            $old_file = Storage::disk('public')->path($this->uploadPath_thumb.$eventGallery->image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_thumb.$eventGallery->image);

            request()->merge(['image' => $imagename]);
        }

        // update database
        $eventGallery->update(request()->all());
        $eventGallery->save();

        // set message and redirect
        session()->flash('success','Event gallery updated successfully.');
        return redirect()->route('admin::eventGallery',$event_id);
    }

    public function destroy($event_id, $id, EventGallery $eventGallery)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $eventGallery = $eventGallery->find($id);

        // delete file
        $old_file = Storage::disk('public')->path($this->uploadPath.$eventGallery->image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$eventGallery->image);
        $old_file = Storage::disk('public')->path($this->uploadPath_thumb.$eventGallery->image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_thumb.$eventGallery->image);

        // delete data
        $eventGallery->delete();

        // set message and redirect
        session()->flash('success','Event gallery deleted successfully.');
        return redirect()->route('admin::eventGallery',$event_id);
    }

    public function change_status($event_id, $id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        EventGallery::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','Event gallery status changed successfully.');
        return redirect()->route('admin::eventGallery',$event_id);
    }
}
