<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\AdminModels\LoftDesigner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class LoftDesignerController extends Controller
{
    private $uploadPath = 'loft_designer/actual/';
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
        $data = LoftDesigner::all();
        return view('admin.loft_designer.index',compact('data','access_type'));
    }


    public function create()
    {
        abort_unless(in_array('add',$this->access_type), 403);
        return view('admin.loft_designer.create');
    }

    public function store(Request $request)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'imagefile' => 'required|image|mimes:jpeg,jpg|max:4096',
            'name' => 'required',
            'about' => 'required',
            'active' => 'required',
        ]);

        $image = request()->imagefile;
        $imagename = filterFileName($image);
        if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
            return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
        }
        request()->merge(['image' => $imagename]);

        // insert into database
        LoftDesigner::create(request()->all());

        // set message and redirect
        session()->flash('success','Loft Designer added successfully.');
        return redirect()->route('admin::loftDesigner');
    }

    public function edit($id, LoftDesigner $loftDesigner)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $loftDesigner->find($id);
        return view('admin.loft_designer.edit',compact('data'));
    }

    public function update($id, Request $request, LoftDesigner $loftDesigner)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'imagefile' => 'image|mimes:jpeg,jpg|max:4096',
            'name' => 'required',
            'about' => 'required',
            'active' => 'required',
        ]);

        $loftDesigner = $loftDesigner->find($id);

        if (request()->hasFile('imagefile')) {
            $image = request()->imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
                return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
            }
            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath.$loftDesigner->image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$loftDesigner->image);

            request()->merge(['image' => $imagename]);
        }

        // update database
        $loftDesigner->update(request()->all());
        $loftDesigner->save();

        // set message and redirect
        session()->flash('success','Loft Designer updated successfully.');
        return redirect()->route('admin::loftDesigner');
    }

    public function destroy($id, LoftDesigner $loftDesigner)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $loftDesigner = $loftDesigner->find($id);

        // delete file
        $old_file = Storage::disk('public')->path($this->uploadPath.$loftDesigner->image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$loftDesigner->image);

        // reset priority
        LoftDesigner::resetOrder($loftDesigner->priority);

        // delete data
        $loftDesigner->delete();

        // set message and redirect
        session()->flash('success','Loft Designer deleted successfully.');
        return redirect()->route('admin::loftDesigner');
    }

    public function change_status($id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        LoftDesigner::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','Loft Designer status changed successfully.');
        return redirect()->route('admin::loftDesigner');
    }

}
