<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\AdminModels\Qreview;
use App\Models\AdminModels\Qauthor;
use App\Models\AdminModels\ReviewTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;


class QreviewController extends Controller
{
    private $uploadPath = 'qreview/actual/';
    private $uploadPath_thumb = 'qreview/thumb/';
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
        $data = Qreview::all();
        return view('admin.qreview.index',compact('data','access_type'));
    }


    public function create()
    {
        abort_unless(in_array('add',$this->access_type), 403);
        $tags = ReviewTag::all();
        $author = Qauthor::all();
        return view('admin.qreview.create',compact('tags','author'));
    }

    public function store(Request $request)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'author' => 'required|array',
            'slug' => 'required|unique:qreview,slug',
            'meta_imagefile' => 'image|mimes:jpeg,png,jpg|max:1024',
            'imagefile' => 'required|image|mimes:jpeg,png,jpg|max:4096',
            'sq_imagefile' => 'required|image|mimes:jpeg,png,jpg|max:4096',
            'content' => 'required',
            'rating' => 'required',
            'tags' => 'required|array',
            'post_time' => 'required',
            'active' => 'required',
        ]);

        if(request()->tags) request()->merge(['tags' => implode(',',request()->tags)]);
        if(request()->author) request()->merge(['author' => implode(',',request()->author)]);

        // fileupload
        $image = request()->imagefile;
        $imagename = filterFileName($image);
        if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
            return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
        }
        request()->merge(['image' => $imagename]);

        $image = request()->sq_imagefile;
        $imagename = filterFileName($image);
        if($image->storePubliclyAs($this->uploadPath_thumb, $imagename)==false){
            return back()->withErrors(['sq_imagefile'=>'Cannot upload to server.']);
        }
        request()->merge(['sq_image' => $imagename]);

        if (request()->hasFile('meta_imagefile')) {
            $image = request()->meta_imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath_meta, $imagename)==false){
                return back()->withErrors(['meta_imagefile'=>'Cannot upload to server.']);
            }
            request()->merge(['meta_image' => $imagename]);
        }

        // insert into database
        Qreview::create(request()->all());

        // set message and redirect
        session()->flash('success','Qreview post added successfully.');
        return redirect()->route('admin::qreview');
    }

    public function edit($id, Qreview $qreview)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $qreview->find($id);
        $tags = ReviewTag::all();
        $author = Qauthor::all();
        return view('admin.qreview.edit',compact('data','tags','author'));
    }

    public function update($id, Request $request, Qreview $qreview)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'author' => 'required|array',
            'slug' => ['required',Rule::unique('qreview')->ignore($id)],
            'content' => 'required',
            'imagefile' => 'image|mimes:jpeg,png,jpg|max:4096',
            'sq_imagefile' => 'image|mimes:jpeg,png,jpg|max:4096',
            'rating' => 'required',
            'post_time' => 'required',
            'tags' => 'required|array',
            'meta_imagefile' => 'image|mimes:jpeg,png,jpg|max:1024',
            'active' => 'required',
        ]);

        if(request()->tags) request()->merge(['tags' => implode(',',request()->tags)]);
        if(request()->author) request()->merge(['author' => implode(',',request()->author)]);

        $qreview = $qreview->find($id);

        // fileupload
        if (request()->hasFile('imagefile')) {
            $image = request()->imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
                return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
            }
            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath.$qreview->image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$qreview->image);

            request()->merge(['image' => $imagename]);
        }

        if (request()->hasFile('sq_imagefile')) {
            $image = request()->sq_imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath_thumb, $imagename)==false){
                return back()->withErrors(['sq_imagefile'=>'Cannot upload to server.']);
            }
            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath_thumb.$qreview->sq_image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_thumb.$qreview->sq_image);

            request()->merge(['sq_image' => $imagename]);
        }

        if (request()->hasFile('meta_imagefile')) {
            $image = request()->meta_imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath_meta, $imagename)==false){
                return back()->withErrors(['meta_imagefile'=>'Cannot upload to server.']);
            }
            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath_meta.$qreview->meta_image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_meta.$qreview->meta_image);

            request()->merge(['meta_image' => $imagename]);
        }

        // update database
        $qreview->update(request()->all());
        $qreview->save();

        // set message and redirect
        session()->flash('success','Qreview post updated successfully.');
        return redirect()->route('admin::qreview');
    }

    public function destroy($id, Qreview $qreview)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $qreview = $qreview->find($id);

        // delete file
        $old_file = Storage::disk('public')->path($this->uploadPath.$qreview->image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$qreview->image);
        $old_file = Storage::disk('public')->path($this->uploadPath_thumb.$qreview->sq_image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_thumb.$qreview->image);
        $old_file = Storage::disk('public')->path($this->uploadPath_meta.$qreview->meta_image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_meta.$qreview->meta_image);

        // delete data
        $qreview->delete();

        // set message and redirect
        session()->flash('success','Qreview post deleted successfully.');
        return redirect()->route('admin::qreview');
    }

    public function change_status($id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        Qreview::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','Qreview post status changed successfully.');
        return redirect()->route('admin::qreview');
    }

}
