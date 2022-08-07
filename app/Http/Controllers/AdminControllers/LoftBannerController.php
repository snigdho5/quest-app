<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\AdminModels\LoftBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class LoftBannerController extends Controller
{
    private $uploadPath = 'loft_banner/actual/';
    private $appuploadPath = 'loft_banner/app/';
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
        $data = LoftBanner::all();
        return view('admin.loft_banner.index',compact('data','access_type'));
    }


    public function create()
    {
        abort_unless(in_array('add',$this->access_type), 403);
        return view('admin.loft_banner.create');
    }

    public function store(Request $request)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'imagefile' => 'required|image|mimes:jpeg,jpg|max:4096',
            'appimagefile' => 'required|image|mimes:jpeg,jpg|max:4096|dimensions:ratio=16/9',
            'active' => 'required',
        ]);

        // ordering funtionality
        request()->merge(['priority' => LoftBanner::count()+1]);

        $image = request()->imagefile;
        $imagename = filterFileName($image);
        if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
            return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
        }
        request()->merge(['image' => $imagename]);

        $image = request()->appimagefile;
        $imagename = filterFileName($image);
        if($image->storePubliclyAs($this->appuploadPath, $imagename)==false){
            return back()->withErrors(['appimagefile'=>'Cannot upload to server.']);
        }
        request()->merge(['app_image' => $imagename]);


        // insert into database
        LoftBanner::create(request()->all());

        // set message and redirect
        session()->flash('success','Loft Banner added successfully.');
        return redirect()->route('admin::loftBanner');
    }

    public function edit($id, LoftBanner $loftBanner)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $loftBanner->find($id);
        return view('admin.loft_banner.edit',compact('data'));
    }

    public function update($id, Request $request, LoftBanner $loftBanner)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'imagefile' => 'image|mimes:jpeg,jpg|max:4096',
            'appimagefile' => 'required|image|mimes:jpeg,jpg|max:4096|dimensions:ratio=16/9',
            'active' => 'required',
        ]);

        $loftBanner = $loftBanner->find($id);

        if (request()->hasFile('imagefile')) {
            $image = request()->imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
                return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
            }
            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath.$loftBanner->image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$loftBanner->image);

            request()->merge(['image' => $imagename]);
        }

        if (request()->hasFile('appimagefile')) {
            $image = request()->appimagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->appuploadPath, $imagename)==false){
                return back()->withErrors(['appimagefile'=>'Cannot upload to server.']);
            }
            // delete old file
            $old_file = Storage::disk('public')->path($this->appuploadPath.$loftBanner->app_image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->appuploadPath.$loftBanner->app_image);

            request()->merge(['app_image' => $imagename]);
        }

        // update database
        $loftBanner->update(request()->all());
        $loftBanner->save();

        // set message and redirect
        session()->flash('success','Loft Banner updated successfully.');
        return redirect()->route('admin::loftBanner');
    }

    public function destroy($id, LoftBanner $loftBanner)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $loftBanner = $loftBanner->find($id);

        // delete file
        $old_file = Storage::disk('public')->path($this->uploadPath.$loftBanner->image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$loftBanner->image);
        $old_file = Storage::disk('public')->path($this->appuploadPath.$loftBanner->app_image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->appuploadPath.$loftBanner->app_image);

        // reset priority
        LoftBanner::resetOrder($loftBanner->priority);

        // delete data
        $loftBanner->delete();

        // set message and redirect
        session()->flash('success','Loft Banner deleted successfully.');
        return redirect()->route('admin::loftBanner');
    }

    public function change_status($id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        LoftBanner::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','Loft Banner status changed successfully.');
        return redirect()->route('admin::loftBanner');
    }

    public function order(Request $request)
    {
        abort_unless(in_array('order',$this->access_type), 403);
        $oldOrder = intVal(LoftBanner::find(request()->id)->priority);
        $newOrder = intVal(request()->o);

        if($oldOrder < $newOrder)
            LoftBanner::where([['priority','>', $oldOrder],['priority','<=', $newOrder]])->decrement('priority',1);
        else LoftBanner::where([['priority','<', $oldOrder],['priority','>=', $newOrder]])->increment('priority',1);

        LoftBanner::find(request()->id)->update(['priority'=>request()->o]);

        // set message and redirect
        session()->flash('success','Loft Banner order changed successfully.');
        return redirect()->route('admin::loftBanner');
    }
}
