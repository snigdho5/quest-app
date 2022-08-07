<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\AdminModels\Award;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class AwardController extends Controller
{
    private $uploadPath = 'award/actual/';
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
        $data = Award::all();
        return view('admin.award.index',compact('data','access_type'));
    }


    public function create()
    {
        abort_unless(in_array('add',$this->access_type), 403);
        return view('admin.award.create');
    }

    public function store(Request $request)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'imagefile' => 'required|image|mimes:jpeg,jpg|max:4096',
            'category' => 'required',
            'organiser' => 'required',
            'date' => 'required',
            'venue' => 'required',
            'active' => 'required',
        ]);

        $image = request()->imagefile;
        $imagename = filterFileName($image);
        if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
            return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
        }
        request()->merge(['image' => $imagename]);


        // insert into database
        Award::create(request()->all());

        // set message and redirect
        session()->flash('success','Award added successfully.');
        return redirect()->route('admin::award');
    }

    public function edit($id, Award $award)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $award->find($id);
        return view('admin.award.edit',compact('data'));
    }

    public function update($id, Request $request, Award $award)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'imagefile' => 'image|mimes:jpeg,jpg|max:4096',
            'category' => 'required',
            'organiser' => 'required',
            'date' => 'required',
            'venue' => 'required',
            'active' => 'required',
        ]);

        $award = $award->find($id);

        if (request()->hasFile('imagefile')) {
            $image = request()->imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
                return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
            }
            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath.$award->image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$award->image);

            request()->merge(['image' => $imagename]);
        }

        // update database
        $award->update(request()->all());
        $award->save();

        // set message and redirect
        session()->flash('success','Award updated successfully.');
        return redirect()->route('admin::award');
    }

    public function destroy($id, Award $award)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $award = $award->find($id);

        // delete file
        $old_file = Storage::disk('public')->path($this->uploadPath.$award->image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$award->image);

        // delete data
        $award->delete();

        // set message and redirect
        session()->flash('success','Award deleted successfully.');
        return redirect()->route('admin::award');
    }

    public function change_status($id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        Award::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','Award status changed successfully.');
        return redirect()->route('admin::award');
    }
}
