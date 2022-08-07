<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\AdminModels\AppBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class AppBannerController extends Controller
{
    private $uploadPath = 'app_banner/actual/';
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
        $data = AppBanner::all();
        return view('admin.app_banner.index',compact('data','access_type'));
    }


    public function create()
    {
        abort_unless(in_array('add',$this->access_type), 403);
        return view('admin.app_banner.create');
    }

    public function store(Request $request)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'imagefile' => 'required|image|mimes:jpeg,jpg|max:4096|dimensions:width=660,height=371',
            'active' => 'required',
        ]);

        // ordering funtionality
        request()->merge(['priority' => AppBanner::count()+1]);

        $image = request()->imagefile;
        $imagename = filterFileName($image);
        if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
            return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
        }
        request()->merge(['image' => $imagename]);


        // insert into database
        AppBanner::create(request()->all());

        // set message and redirect
        session()->flash('success','App Banner added successfully.');
        return redirect()->route('admin::appBanner');
    }

    public function edit($id, AppBanner $appBanner)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $appBanner->find($id);
        return view('admin.app_banner.edit',compact('data'));
    }

    public function update($id, Request $request, AppBanner $appBanner)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'imagefile' => 'image|mimes:jpeg,jpg|max:4096|dimensions:width=660,height=371',
            'active' => 'required',
        ]);

        $appBanner = $appBanner->find($id);

        if (request()->hasFile('imagefile')) {
            $image = request()->imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
                return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
            }
            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath.$appBanner->image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$appBanner->image);

            request()->merge(['image' => $imagename]);
        }

        // update database
        $appBanner->update(request()->all());
        $appBanner->save();

        // set message and redirect
        session()->flash('success','App Banner updated successfully.');
        return redirect()->route('admin::appBanner');
    }

    public function destroy($id, AppBanner $appBanner)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $appBanner = $appBanner->find($id);

        // delete file
        $old_file = Storage::disk('public')->path($this->uploadPath.$appBanner->image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$appBanner->image);

        // reset priority
        AppBanner::resetOrder($appBanner->priority);

        // delete data
        $appBanner->delete();

        // set message and redirect
        session()->flash('success','App Banner deleted successfully.');
        return redirect()->route('admin::appBanner');
    }

    public function change_status($id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        AppBanner::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','App Banner status changed successfully.');
        return redirect()->route('admin::appBanner');
    }

    public function order(Request $request)
    {
        abort_unless(in_array('order',$this->access_type), 403);
        $oldOrder = intVal(AppBanner::find(request()->id)->priority);
        $newOrder = intVal(request()->o);

        if($oldOrder < $newOrder)
            AppBanner::where([['priority','>', $oldOrder],['priority','<=', $newOrder]])->decrement('priority',1);
        else AppBanner::where([['priority','<', $oldOrder],['priority','>=', $newOrder]])->increment('priority',1);

        AppBanner::find(request()->id)->update(['priority'=>request()->o]);

        // set message and redirect
        session()->flash('success','App Banner order changed successfully.');
        return redirect()->route('admin::appBanner');
    }
}
