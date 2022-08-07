<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\AdminModels\StoreDeal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class DineDealController extends Controller
{
    private $uploadPath = 'store_deal/actual/';
    private $uploadPath_thumb = 'store_deal/thumb/';
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
        $data = StoreDeal::where('store_id',$store_id)->get();
        return view('admin.dine_deal.index',compact('data','access_type', 'store_id'));
    }


    public function create($store_id)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        return view('admin.dine_deal.create',compact('store_id'));
    }

    public function store($store_id, Request $request)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'beacon_type' => 'required',
            'imagefile' => 'required_if:beacon_type,0|image|mimes:jpeg,jpg|max:4096',
            'active' => 'required',
        ]);

        request()->merge(['store_id' => $store_id]);

        $image = request()->imagefile;
        $imagename = filterFileName($image);
        if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
            return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
        }else{
            image_crop($image, Storage::disk('public')->path($this->uploadPath_thumb.$imagename),500);
        }
        request()->merge(['image' => $imagename]);


        // insert into database
        StoreDeal::create(request()->all());

        // set message and redirect
        session()->flash('success','Dine Deal added successfully.');
        return redirect()->route('admin::dineDeal',$store_id);
    }

    public function edit($store_id, $id, StoreDeal $dineDeal)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $dineDeal->find($id);
        return view('admin.dine_deal.edit',compact('data','store_id'));
    }

    public function update($store_id, $id, Request $request, StoreDeal $dineDeal)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'beacon_type' => 'required',
            'imagefile' => 'image|mimes:jpeg,jpg|max:4096',
            'active' => 'required',
        ]);

        $dineDeal = $dineDeal->find($id);

        if (request()->hasFile('imagefile')) {
            $image = request()->imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
                return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
            }else{
                image_crop($image, Storage::disk('public')->path($this->uploadPath_thumb.$imagename),500);
            }
            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath.$dineDeal->image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$dineDeal->image);
            $old_file = Storage::disk('public')->path($this->uploadPath_thumb.$dineDeal->image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_thumb.$dineDeal->image);

            request()->merge(['image' => $imagename]);
        }

        // update database
        $dineDeal->update(request()->all());
        $dineDeal->save();

        // set message and redirect
        session()->flash('success','Dine Deal updated successfully.');
        return redirect()->route('admin::dineDeal',$store_id);
    }

    public function destroy($store_id, $id, StoreDeal $dineDeal)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $dineDeal = $dineDeal->find($id);

        // delete file
        $old_file = Storage::disk('public')->path($this->uploadPath.$dineDeal->image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$dineDeal->image);

        $old_file = Storage::disk('public')->path($this->uploadPath_thumb.$dineDeal->image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_thumb.$dineDeal->image);

        // delete data
        $dineDeal->delete();

        // set message and redirect
        session()->flash('success','Dine Deal deleted successfully.');
        return redirect()->route('admin::dineDeal',$store_id);
    }

    public function change_status($store_id, $id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        StoreDeal::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','Dine Deal status changed successfully.');
        return redirect()->route('admin::dineDeal',$store_id);
    }
}
