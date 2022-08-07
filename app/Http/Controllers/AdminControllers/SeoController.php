<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\AdminModels\Seo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SeoController extends Controller
{
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
        $data = Seo::all();
        return view('admin.seo.index',compact('data','access_type'));
    }


    public function create()
    {
        abort_unless(in_array('add',$this->access_type), 403);
        return view('admin.seo.create');
    }

    public function store(Request $request)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'link' => 'required',
            'meta_title' => 'required',
            'meta_desc' => 'required',
            'meta_keyword' => 'required',
            'meta_imagefile' => 'image|mimes:jpeg,png,jpg|max:1024',
            'active' => 'required',
        ]);

        if (request()->hasFile('meta_imagefile')) {
            $image = request()->meta_imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath_meta, $imagename)==false){
                return back()->withErrors(['meta_imagefile'=>'Cannot upload to server.']);
            }
            request()->merge(['image' => $imagename]);
        }

        // insert into database
        Seo::create(request()->all());

        // set message and redirect
        session()->flash('success','Seo data added successfully.');
        return redirect()->route('admin::seo');
    }

    public function edit($id, Seo $seo)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $seo->find($id);
        return view('admin.seo.edit',compact('data'));
    }

    public function update($id, Request $request, Seo $seo)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'link' => 'required',
            'meta_title' => 'required',
            'meta_desc' => 'required',
            'meta_keyword' => 'required',
            'meta_imagefile' => 'image|mimes:jpeg,png,jpg|max:1024',
            'active' => 'required',
        ]);

        $seo = $seo->find($id);

        if (request()->hasFile('meta_imagefile')) {
            $image = request()->meta_imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath_meta, $imagename)==false){
                return back()->withErrors(['meta_imagefile'=>'Cannot upload to server.']);
            }
            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath_meta.$seo->image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_meta.$seo->image);

            request()->merge(['image' => $imagename]);
        }

        // update database
        $seo->update(request()->all());
        $seo->save();

        // set message and redirect
        session()->flash('success','Seo data updated successfully.');
        return redirect()->route('admin::seo');
    }

    public function destroy($id, Seo $seo)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $seo = $seo->find($id);

        // delete file
        $old_file = Storage::disk('public')->path($this->uploadPath_meta.$seo->image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_meta.$seo->image);

        // delete data
        $seo->delete();

        // set message and redirect
        session()->flash('success','Seo data deleted successfully.');
        return redirect()->route('admin::seo');
    }

    public function change_status($id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        Seo::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','Seo data status changed successfully.');
        return redirect()->route('admin::seo');
    }
}
