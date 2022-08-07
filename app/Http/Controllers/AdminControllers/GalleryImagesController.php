<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\AdminModels\GalleryImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class GalleryImagesController extends Controller
{
    private $uploadPath = 'gallery/actual/';
    private $uploadPath_thumb = 'gallery/thumb/';
    protected $access_type;

    public function __construct(){
        $this->middleware('auth:admin');
        $this->middleware(function ($request, $next) {
            $this->access_type = checkAccess(auth()->guard('admin')->user()->role);
            if(count($this->access_type)==0) abort(403);
            return $next($request);
        });
    }

    public function index($gallery_id)
    {
        $access_type = $this->access_type;
        $data = GalleryImages::where('gallery_id',$gallery_id)->get();
        return view('admin.gallery_image.index',compact('data','access_type', 'gallery_id'));
    }


    public function create($gallery_id)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        return view('admin.gallery_image.create',compact('gallery_id'));
    }

    public function store($gallery_id, Request $request)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'imagefile' => 'required|image|mimes:jpeg,jpg|max:4096',
            'active' => 'required',
        ]);

        request()->merge(['gallery_id' => $gallery_id]);

        $image = request()->imagefile;
        $imagename = filterFileName($image);
        if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
            return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
        }else{
            image_crop($image, Storage::disk('public')->path($this->uploadPath_thumb.$imagename),500);
        }
        request()->merge(['image' => $imagename]);


        // insert into database
        GalleryImages::create(request()->all());

        // set message and redirect
        session()->flash('success','Gallery image added successfully.');
        return redirect()->route('admin::galleryImages',$gallery_id);
    }

    public function edit($gallery_id, $id, GalleryImages $galleryImage)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $galleryImage->find($id);
        return view('admin.gallery_image.edit',compact('data','gallery_id'));
    }

    public function update($gallery_id, $id, Request $request, GalleryImages $galleryImage)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'imagefile' => 'image|mimes:jpeg,jpg|max:4096',
            'active' => 'required',
        ]);

        $galleryImage = $galleryImage->find($id);

        if (request()->hasFile('imagefile')) {
            $image = request()->imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
                return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
            }else{
                image_crop($image, Storage::disk('public')->path($this->uploadPath_thumb.$imagename),500);
            }
            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath.$galleryImage->image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$galleryImage->image);
            $old_file = Storage::disk('public')->path($this->uploadPath_thumb.$galleryImage->image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_thumb.$galleryImage->image);

            request()->merge(['image' => $imagename]);
        }

        // update database
        $galleryImage->update(request()->all());
        $galleryImage->save();

        // set message and redirect
        session()->flash('success','Gallery image updated successfully.');
        return redirect()->route('admin::galleryImages',$gallery_id);
    }

    public function destroy($gallery_id, $id, GalleryImages $galleryImage)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $galleryImage = $galleryImage->find($id);

        // delete file
        $old_file = Storage::disk('public')->path($this->uploadPath.$galleryImage->image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$galleryImage->image);
        $old_file = Storage::disk('public')->path($this->uploadPath_thumb.$galleryImage->image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_thumb.$galleryImage->image);

        // delete data
        $galleryImage->delete();

        // set message and redirect
        session()->flash('success','Gallery image deleted successfully.');
        return redirect()->route('admin::galleryImages',$gallery_id);
    }

    public function change_status($gallery_id, $id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        GalleryImages::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','Gallery image status changed successfully.');
        return redirect()->route('admin::galleryImages',$gallery_id);
    }
}
