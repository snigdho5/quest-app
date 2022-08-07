<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\AdminModels\CameraFrame;
use App\Models\AdminModels\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class CameraFrameController extends Controller
{
    private $uploadPath = 'camera_frame/actual/';
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
        $data = CameraFrame::all();
        return view('admin.camera_frame.index',compact('data','access_type'));
    }


    public function create()
    {
        abort_unless(in_array('add',$this->access_type), 403);
        $store = Store::all();
        return view('admin.camera_frame.create',compact('store'));
    }

    public function store(Request $request)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        // validation
        $this->validate(request(),[
        	'imagefile'  => 'required|image|mimes:png|max:4096',
        	'active'  => 'required',
        ]);

        $image = request()->imagefile;
        $imagename = filterFileName($image);
        if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
            return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
        }
        request()->merge(['image' => $imagename]);


        // insert into database
        CameraFrame::create(request()->all());

        // set message and redirect
        session()->flash('success','Camera Frame added successfully.');
        return redirect()->route('admin::cameraFrame');
    }

    public function edit($id, CameraFrame $cameraFrame)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $cameraFrame->find($id);
        $store = Store::all();
        return view('admin.camera_frame.edit',compact('data','store'));
    }

    public function update($id, Request $request, CameraFrame $cameraFrame)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        // validation
        $this->validate(request(),[
        	'imagefile'  => 'image|mimes:png|max:4096',
        	'active'  => 'required'
        ]);

        $cameraFrame = $cameraFrame->find($id);

        if (request()->hasFile('imagefile')) {
            $image = request()->imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
                return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
            }
            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath.$cameraFrame->image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$cameraFrame->image);

            request()->merge(['image' => $imagename]);
        }

        // update database
        $cameraFrame->update(request()->all());
        $cameraFrame->save();

        // set message and redirect
        session()->flash('success','Camera Frame updated successfully.');
        return redirect()->route('admin::cameraFrame');
    }

    public function destroy($id, CameraFrame $cameraFrame)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $cameraFrame = $cameraFrame->find($id);

        // delete file
        $old_file = Storage::disk('public')->path($this->uploadPath.$cameraFrame->image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$cameraFrame->image);

        // delete data
        $cameraFrame->delete();

        // set message and redirect
        session()->flash('success','Camera Frame deleted successfully.');
        return redirect()->route('admin::cameraFrame');
    }

    public function change_status($id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        CameraFrame::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','Camera Frame status changed successfully.');
        return redirect()->route('admin::cameraFrame');
    }
}
