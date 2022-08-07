<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\AdminModels\QreviewGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class QreviewGalleryController extends Controller
{
    private $uploadPath = 'qreview_gallery/actual/';
    private $uploadPath_thumb = 'qreview_gallery/thumb/';
    private $uploadPath_app = 'qreview_gallery/app/';
    protected $access_type;

    public function __construct(){
        $this->middleware('auth:admin');
        $this->middleware(function ($request, $next) {
            $this->access_type = checkAccess(auth()->guard('admin')->user()->role);
            if(count($this->access_type)==0) abort(403);
            return $next($request);
        });
    }

    public function index($q_id)
    {
        $access_type = $this->access_type;
        $data = QreviewGallery::where('q_id',$q_id)->get();
        return view('admin.qreview_gallery.index',compact('data','access_type', 'q_id'));
    }


    public function create($q_id)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        return view('admin.qreview_gallery.create',compact('q_id'));
    }

    public function store($q_id, Request $request)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'imagefile' => 'required|image|mimes:jpeg,jpg|max:4096',
            'active' => 'required',
        ]);

        request()->merge(['q_id' => $q_id]);

        // ordering funtionality
        request()->merge(['priority' => QreviewGallery::where('q_id',request('q_id'))->count()+1]);

        $image = request()->imagefile;
        $imagename = filterFileName($image);
        if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
            return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
        }else{
            image_crop($image, Storage::disk('public')->path($this->uploadPath_thumb.$imagename),500);
        }
        request()->merge(['image' => $imagename]);

        // $aimage = request()->aimagefile;
        // $aimagename = filterFileName($aimage);
        // if($aimage->storePubliclyAs($this->uploadPath_app, $aimagename)==false){
        //     return back()->withErrors(['aimagefile'=>'Cannot upload to server.']);
        // }
        // request()->merge(['app_image' => $aimagename]);


        // insert into database
        $data = QreviewGallery::create(request()->all());

        //reset all featured image
        // if(request()->featured == '1') QreviewGallery::where([['id','!=', $data->id],['q_id',$q_id]])->update(array('featured'=>0));

        // set message and redirect
        session()->flash('success','Qreview Gallery added successfully.');
        return redirect()->route('admin::qreviewGallery',$q_id);
    }

    public function edit($q_id, $id, QreviewGallery $qreviewGallery)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $qreviewGallery->find($id);
        return view('admin.qreview_gallery.edit',compact('data','q_id'));
    }

    public function update($q_id, $id, Request $request, QreviewGallery $qreviewGallery)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'imagefile' => 'image|mimes:jpeg,jpg|max:4096',
            'active' => 'required',
        ]);

        $qreviewGallery = $qreviewGallery->find($id);

        if (request()->hasFile('imagefile')) {
            $image = request()->imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
                return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
            }else{
                image_crop($image, Storage::disk('public')->path($this->uploadPath_thumb.$imagename),500);
            }
            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath.$qreviewGallery->image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$qreviewGallery->image);
            $old_file = Storage::disk('public')->path($this->uploadPath_thumb.$qreviewGallery->image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_thumb.$qreviewGallery->image);

            request()->merge(['image' => $imagename]);
        }
        if (request()->hasFile('aimagefile')) {
            $aimage = request()->aimagefile;
            $aimagename = filterFileName($aimage);
            if($aimage->storePubliclyAs($this->uploadPath_app, $aimagename)==false){
                return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
            }
            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath_app.$qreviewGallery->app_image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_app.$qreviewGallery->app_image);

            request()->merge(['app_image' => $aimagename]);
        }

        // update database
        $qreviewGallery->update(request()->all());
        $qreviewGallery->save();

        //reset all featured image
        // if(request()->featured == '1') QreviewGallery::where([['id','!=', $id],['q_id',$q_id]])->update(array('featured'=>0));

        // set message and redirect
        session()->flash('success','Qreview Gallery updated successfully.');
        return redirect()->route('admin::qreviewGallery',$q_id);
    }

    public function destroy($q_id, $id, QreviewGallery $qreviewGallery)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $qreviewGallery = $qreviewGallery->find($id);

        // delete file
        $old_file = Storage::disk('public')->path($this->uploadPath.$qreviewGallery->image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$qreviewGallery->image);
        $old_file = Storage::disk('public')->path($this->uploadPath_thumb.$qreviewGallery->image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_thumb.$qreviewGallery->image);
        // $old_file = Storage::disk('public')->path($this->uploadPath_app.$qreviewGallery->app_image);
        // if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_app.$qreviewGallery->app_image);

        // reset priority
        QreviewGallery::resetOrder($qreviewGallery->priority,$qreviewGallery->q_id);

        // delete data
        $qreviewGallery->delete();

        // set message and redirect
        session()->flash('success','Qreview Gallery deleted successfully.');
        return redirect()->route('admin::qreviewGallery',$q_id);
    }

    public function change_status($q_id, $id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        QreviewGallery::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','Qreview Gallery status changed successfully.');
        return redirect()->route('admin::qreviewGallery',$q_id);
    }

    public function order($q_id, Request $request)
    {
        abort_unless(in_array('order',$this->access_type), 403);
        $oldOrder = intVal(QreviewGallery::find(request()->id)->priority);
        $q_id = intVal(QreviewGallery::find(request()->id)->q_id);
        $newOrder = intVal(request()->o);

        if($oldOrder < $newOrder)
            QreviewGallery::where([['q_id', $q_id],['priority','>', $oldOrder],['priority','<=', $newOrder]])->decrement('priority',1);
        else QreviewGallery::where([['q_id', $q_id],['priority','<', $oldOrder],['priority','>=', $newOrder]])->increment('priority',1);

        QreviewGallery::find(request()->id)->update(['priority'=>request()->o]);

        // set message and redirect
        session()->flash('success','Qreview Gallery changed successfully.');
        return redirect()->route('admin::qreviewGallery',$q_id);
    }
}
