<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\AdminModels\MoviePoster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class MoviePosterController extends Controller
{
	private $uploadPath = 'movie_poster/actual/';
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
        $data = MoviePoster::all();
        return view('admin.movie_poster.index',compact('data','access_type'));
    }


    public function create()
    {
        abort_unless(in_array('add',$this->access_type), 403);
        return view('admin.movie_poster.create');
    }

    public function store(Request $request)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'imagefile' => 'required|image|mimes:jpeg,jpg|max:4096',
            'link' => 'required|url',
            'active' => 'required',
        ]);

        // ordering funtionality
        request()->merge(['priority' => MoviePoster::count()+1]);

        $image = request()->imagefile;
        $imagename = filterFileName($image);
        if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
            return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
        }
        request()->merge(['image' => $imagename]);


        // insert into database
        MoviePoster::create(request()->all());

        // set message and redirect
        session()->flash('success','Movie Poster added successfully.');
        return redirect()->route('admin::moviePoster');
    }

    public function edit($id, MoviePoster $moviePoster)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $moviePoster->find($id);
        return view('admin.movie_poster.edit',compact('data'));
    }

    public function update($id, Request $request, MoviePoster $moviePoster)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'imagefile' => 'image|mimes:jpeg,jpg|max:4096',
            'link' => 'required|url',
            'active' => 'required',
        ]);

        $moviePoster = $moviePoster->find($id);

        if (request()->hasFile('imagefile')) {
            $image = request()->imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
                return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
            }
            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath.$moviePoster->image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$moviePoster->image);

            request()->merge(['image' => $imagename]);
        }

        // update database
        $moviePoster->update(request()->all());
        $moviePoster->save();

        // set message and redirect
        session()->flash('success','Movie Poster updated successfully.');
        return redirect()->route('admin::moviePoster');
    }

    public function destroy($id, MoviePoster $moviePoster)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $moviePoster = $moviePoster->find($id);

        // delete file
        $old_file = Storage::disk('public')->path($this->uploadPath.$moviePoster->image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$moviePoster->image);

        // reset priority
        MoviePoster::resetOrder($moviePoster->priority);

        // delete data
        $moviePoster->delete();

        // set message and redirect
        session()->flash('success','Movie Poster deleted successfully.');
        return redirect()->route('admin::moviePoster');
    }

    public function change_status($id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        MoviePoster::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','Movie Poster status changed successfully.');
        return redirect()->route('admin::moviePoster');
    }

    public function order(Request $request)
    {
        abort_unless(in_array('order',$this->access_type), 403);
        $oldOrder = intVal(MoviePoster::find(request()->id)->priority);
        $newOrder = intVal(request()->o);

        if($oldOrder < $newOrder)
            MoviePoster::where([['priority','>', $oldOrder],['priority','<=', $newOrder]])->decrement('priority',1);
        else MoviePoster::where([['priority','<', $oldOrder],['priority','>=', $newOrder]])->increment('priority',1);

        MoviePoster::find(request()->id)->update(['priority'=>request()->o]);

        // set message and redirect
        session()->flash('success','Movie Poster order changed successfully.');
        return redirect()->route('admin::moviePoster');
    }
}
