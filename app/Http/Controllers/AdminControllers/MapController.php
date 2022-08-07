<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\AdminModels\Map;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class MapController extends Controller
{
    private $uploadPath = 'map/actual/';
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
        $data = Map::all();
        return view('admin.map.index',compact('data','access_type'));
    }


    public function create()
    {
        abort_unless(in_array('add',$this->access_type), 403);
        return view('admin.map.create');
    }

    public function store(Request $request)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'floor' => 'required',
            'title' => 'required',
            'imagefile' => 'required|image|mimes:jpeg,jpg|max:4096',
            'active' => 'required',
        ]);

        $image = request()->imagefile;
        $imagename = filterFileName($image);
        if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
            return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
        }
        request()->merge(['image' => $imagename]);


        // insert into database
        Map::create(request()->all());

        // set message and redirect
        session()->flash('success','Map added successfully.');
        return redirect()->route('admin::map');
    }

    public function edit($id, Map $map)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $map->find($id);
        return view('admin.map.edit',compact('data'));
    }

    public function update($id, Request $request, Map $map)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'floor' => 'required',
            'title' => 'required',
            'imagefile' => 'image|mimes:jpeg,jpg|max:4096',
            'active' => 'required',
        ]);

        $map = $map->find($id);

        if (request()->hasFile('imagefile')) {
            $image = request()->imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
                return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
            }
            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath.$map->image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$map->image);

            request()->merge(['image' => $imagename]);
        }

        // update database
        $map->update(request()->all());
        $map->save();

        // set message and redirect
        session()->flash('success','Map updated successfully.');
        return redirect()->route('admin::map');
    }

    public function destroy($id, Map $map)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $map = $map->find($id);

        // delete file
        $old_file = Storage::disk('public')->path($this->uploadPath.$map->image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$map->image);

        // delete data
        $map->delete();

        // set message and redirect
        session()->flash('success','Map deleted successfully.');
        return redirect()->route('admin::map');
    }

    public function change_status($id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        Map::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','Map status changed successfully.');
        return redirect()->route('admin::map');
    }

}
