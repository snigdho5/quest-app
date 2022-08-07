<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\AdminModels\StoreDeal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class StoreDealController extends Controller
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
        return view('admin.store_deal.index',compact('data','access_type', 'store_id'));
    }


    public function create($store_id)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        return view('admin.store_deal.create',compact('store_id'));
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

        if (request()->hasFile('imagefile')) {
            $image = request()->imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
                return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
            }else{
                image_crop($image, Storage::disk('public')->path($this->uploadPath_thumb.$imagename),500);
            }
            request()->merge(['image' => $imagename]);
        }


        // insert into database
        StoreDeal::create(request()->all());

        // set message and redirect
        session()->flash('success','Store Deal added successfully.');
        return redirect()->route('admin::storeDeal',$store_id);
    }

    public function edit($store_id, $id, StoreDeal $storeDeal)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $storeDeal->find($id);
        return view('admin.store_deal.edit',compact('data','store_id'));
    }

    public function update($store_id, $id, Request $request, StoreDeal $storeDeal)
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

        $storeDeal = $storeDeal->find($id);

        if (request()->hasFile('imagefile')) {
            $image = request()->imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
                return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
            }else{
                image_crop($image, Storage::disk('public')->path($this->uploadPath_thumb.$imagename),500);
            }
            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath.$storeDeal->image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$storeDeal->image);
            $old_file = Storage::disk('public')->path($this->uploadPath_thumb.$storeDeal->image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_thumb.$storeDeal->image);

            request()->merge(['image' => $imagename]);
        }

        // update database
        $storeDeal->update(request()->all());
        $storeDeal->save();

        // set message and redirect
        session()->flash('success','Store Deal updated successfully.');
        return redirect()->route('admin::storeDeal',$store_id);
    }

    public function destroy($store_id, $id, StoreDeal $storeDeal)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $storeDeal = $storeDeal->find($id);

        // delete file
        $old_file = Storage::disk('public')->path($this->uploadPath.$storeDeal->image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$storeDeal->image);

        $old_file = Storage::disk('public')->path($this->uploadPath_thumb.$storeDeal->image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_thumb.$storeDeal->image);

        // delete data
        $storeDeal->delete();

        // set message and redirect
        session()->flash('success','Store Deal deleted successfully.');
        return redirect()->route('admin::storeDeal',$store_id);
    }

    public function change_status($store_id, $id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        StoreDeal::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','Store Deal status changed successfully.');
        return redirect()->route('admin::storeDeal',$store_id);
    }
}
