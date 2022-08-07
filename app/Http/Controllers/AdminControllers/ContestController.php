<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\AdminModels\Contest;
use App\Models\AdminModels\Store;
use App\Models\AdminModels\ContestDine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class ContestController extends Controller
{
    private $uploadPath = 'contest/actual/';
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
        $data = Contest::all();
        return view('admin.contest.index',compact('data','access_type'));
    }


    public function create()
    {
        abort_unless(in_array('add',$this->access_type), 403);
        $data = Store::where([['s_type','dine'],['active','1']])->get();
        return view('admin.contest.create',compact('data'));
    }

    public function store(Request $request)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        // validation

        $this->validate(request(),[
            'name' => 'required',
            'imagefile' => 'required|image|mimes:jpeg,png,jpg|max:4096',
            'content' => 'required',
            'form_date' => 'required',
            'to_date'=> 'required',
            'unlimited' => 'required',
            'terms' => 'required',
            'dine_ids'=> 'array','required_without:fc_outlets',
            'fc_outlets'=> 'array','required_without:dine_ids',
            'button_name' => 'required',
            'active' => 'required',
        ]);

        // fileupload
        $image = request()->imagefile;
        $imagename = filterFileName($image);
        if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
            return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
        }
        request()->merge(['image' => $imagename]);

        
        // insert into database
        $contest = Contest::create(request()->all());

        if(request('dine_ids')){
            foreach (request('dine_ids') as $key=>$value) {
                ContestDine::create(['contest_id'=>$contest->id,'dine_id'=>$value, 'type'=>1]);
            }
        }

        if(request('fc_outlets')){
            foreach (request('fc_outlets') as $key=>$value) {
                ContestDine::create(['contest_id'=>$contest->id,'dine_id'=>$value, 'type'=>0]);
            }
        }

        // set message and redirect
        session()->flash('success','Contest added successfully.');
        return redirect()->route('admin::contest');
    }

    public function edit($id, Contest $contest)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $contest->find($id);
        $category =Store::where([['s_type','dine'],['active','1']])->get();
        return view('admin.contest.edit',compact('data','category'));
    }

    public function update($id, Request $request, Contest $contest)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        // validation

        $contest = Contest::find($id);
        $this->validate(request(),[
            'name' => 'required',
            'content' => 'required',
            'imagefile' => 'image|mimes:jpeg,png,jpg|max:4096',
            'form_date' => 'required',
            'to_date'=> 'required',
            'terms' => 'required',
            'unlimited' => 'required',
            'dine_ids'=> 'required_without:fc_outlets','array',
            'fc_outlets'=> 'required_without:dine_ids','array',
            'button_name'=> 'required',
            'active' => 'required',
        ]);

        

        if (request()->hasFile('imagefile')) {
            $image = request()->imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
                return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
            }
            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath.$contest->image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$contest->image);

            request()->merge(['image' => $imagename]);
        }


        // update database
        $contest->update(request()->all());
        $contest->save();
        

        ContestDine::where('contest_id',$contest->id)->delete();


        if(request('dine_ids')){
            foreach (request('dine_ids') as $key=>$value) {
                ContestDine::create(['contest_id'=>$contest->id,'dine_id'=>$value, 'type'=>1]);
            }
        }

        if(request('fc_outlets')){
            foreach (request('fc_outlets') as $key=>$value) {
                ContestDine::create(['contest_id'=>$contest->id,'dine_id'=>$value, 'type'=>0]);
            }
        }
        

        // set message and redirect
        session()->flash('success','Contest updated successfully.');
        return redirect()->route('admin::contest');

    }

    public function destroy($id, Contest $contest)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $contest = $contest->find($id);

        $old_file = Storage::disk('public')->path($this->uploadPath.$contest->image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$contest->image);

        ContestDine::where('contest_id',$contest->id)->delete();
        
        // delete data
        $contest->delete();

        // set message and redirect
        session()->flash('success','Contest deleted successfully.');
        return redirect()->route('admin::contest');
    }

    public function change_status($id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        Contest::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','Contest status changed successfully.');
        return redirect()->route('admin::contest');
    }
}
