<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\AdminModels\Event;
use App\Models\AdminModels\LoftDesigner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    private $uploadPath = 'event/actual/';
    private $uploadPath_thumb = 'event/thumb/';
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
        $data = Event::all();
        return view('admin.event.index',compact('data','access_type'));
    }


    public function create()
    {
        abort_unless(in_array('add',$this->access_type), 403);
        $designer = LoftDesigner::all();
        return view('admin.event.create',compact('designer'));
    }

    public function store(Request $request)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'slug' => 'required|unique:event,slug',
            'meta_imagefile' => 'image|mimes:jpeg,png,jpg|max:1024',
            'type' => 'required',
            'content' => 'required',
            'post_time' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'imagefile' => 'required|image|mimes:jpeg,png,jpg|max:4096',
            'sq_imagefile' => 'required|image|mimes:jpeg,png,jpg|max:4096|dimensions:ratio=1',
            'active' => 'required',
        ]);
        if(request()->designers) request()->merge(['designers' => implode(',',request()->designers)]);

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
        Event::create(request()->all());

        // set message and redirect
        session()->flash('success','Event added successfully.');
        return redirect()->route('admin::event');
    }

    public function edit($id, Event $event)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $event->find($id);
        $designer = LoftDesigner::all();
        return view('admin.event.edit',compact('data','designer'));
    }

    public function update($id, Request $request, Event $event)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'slug' => ['required',Rule::unique('event')->ignore($id)],
            'type' => 'required',
            'content' => 'required',
            'imagefile' => 'image|mimes:jpeg,png,jpg|max:4096',
            'sq_imagefile' => 'image|mimes:jpeg,png,jpg|max:4096',
            'post_time' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'meta_imagefile' => 'image|mimes:jpeg,png,jpg|max:1024',
            'active' => 'required',
        ]);

        $event = $event->find($id);
        if(request()->designers) request()->merge(['designers' => implode(',',request()->designers)]);

        // fileupload
        if (request()->hasFile('imagefile')) {
            $image = request()->imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
                return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
            }
            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath.$event->image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$event->image);

            request()->merge(['image' => $imagename]);
        }

        if (request()->hasFile('sq_imagefile')) {
            $image = request()->sq_imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath_thumb, $imagename)==false){
                return back()->withErrors(['sq_imagefile'=>'Cannot upload to server.']);
            }
            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath_thumb.$event->sq_image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_thumb.$event->sq_image);

            request()->merge(['sq_image' => $imagename]);
        }


        if (request()->hasFile('meta_imagefile')) {
            $image = request()->meta_imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath_meta, $imagename)==false){
                return back()->withErrors(['meta_imagefile'=>'Cannot upload to server.']);
            }
            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath_meta.$event->meta_image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_meta.$event->meta_image);

            request()->merge(['meta_image' => $imagename]);
        }

        // update database
        $event->update(request()->all());
        $event->save();

        // set message and redirect
        session()->flash('success','Event updated successfully.');
        return redirect()->route('admin::event');
    }

    public function destroy($id, Event $event)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $event = $event->find($id);

        // delete file
        $old_file = Storage::disk('public')->path($this->uploadPath.$event->image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$event->image);

        $old_file = Storage::disk('public')->path($this->uploadPath_thumb.$event->sq_image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_thumb.$event->sq_image);

        $old_file = Storage::disk('public')->path($this->uploadPath_meta.$event->meta_image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_meta.$event->meta_image);

        // delete data
        $event->delete();

        // set message and redirect
        session()->flash('success','Event deleted successfully.');
        return redirect()->route('admin::event');
    }

    public function change_status($id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        Event::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','Event status changed successfully.');
        return redirect()->route('admin::event');
    }
}
