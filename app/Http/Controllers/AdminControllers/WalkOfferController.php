<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\AdminModels\WalkOffer;
use App\Models\AdminModels\WalkLevel;
use App\Models\AdminModels\Store;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WalkOfferController extends Controller
{
    protected $access_type;
    private $uploadPath = 'walk_offer/actual/';

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
        $data = WalkOffer::all();
        return view('admin.walk_offer.index',compact('data','access_type'));
    }


    public function create()
    {
        abort_unless(in_array('add',$this->access_type), 403);
        $level = WalkLevel::all();
        $store = Store::all();
        return view('admin.walk_offer.create',compact('level','store'));
    }

    public function store(Request $request)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'offer' => 'required',
            'store_id' => 'required',
            'start_date' => 'required',
            'redeem_within' => 'required',
            'threshold' => 'required',
            'code' => 'required',
            'imagefile' => 'required|image|mimes:jpeg,jpg|max:512|dimensions:ratio=2/1',
            'active' => 'required',
        ]);

        if (request()->hasFile('imagefile')) {
            $image = request()->imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
                return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
            }
            request()->merge(['image' => $imagename]);
        }

        // insert into database
        WalkOffer::create(request()->all());

        // set message and redirect
        session()->flash('success','Walk and win offer added successfully.');
        return redirect()->route('admin::walkOffer');
    }

    public function edit($id, WalkOffer $walkOffer)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $walkOffer->find($id);
        $store = Store::all();
        $level = WalkLevel::all();
        return view('admin.walk_offer.edit',compact('data','level','store'));
    }

    public function update($id, Request $request, WalkOffer $walkOffer)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'offer' => 'required',
            'store_id' => 'required',
            'start_date' => 'required',
            'redeem_within' => 'required',
            'threshold' => 'required',
            'code' => 'required',
            'imagefile' => 'image|mimes:jpeg,jpg|max:512|dimensions:ratio=2/1',
            'active' => 'required',
        ]);

        $walkOffer = $walkOffer->find($id);

        if (request()->hasFile('imagefile')) {
            $image = request()->imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
                return back()->withErrors(['imagefile'=>'Cannot upload to server.']);
            }
            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath.$walkOffer->image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$walkOffer->image);

            request()->merge(['image' => $imagename]);
        }

        // update database
        $walkOffer->update(request()->all());
        $walkOffer->save();

        // set message and redirect
        session()->flash('success','Walk and win offer updated successfully.');
        return redirect()->route('admin::walkOffer');
    }

    public function destroy($id, WalkOffer $walkOffer)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $walkOffer = $walkOffer->find($id);

        // delete file
        $old_file = Storage::disk('public')->path($this->uploadPath.$walkOffer->image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$walkOffer->image);

        // delete data
        $walkOffer->delete();

        // set message and redirect
        session()->flash('success','Walk and win offer deleted successfully.');
        return redirect()->route('admin::walkOffer');
    }

    public function change_status($id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        WalkOffer::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','Walk and win offer status changed successfully.');
        return redirect()->route('admin::walkOffer');
    }
}
