<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminModels\StoreRating;

class StoreReviewController extends Controller
{
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
        $data = StoreRating::all();
        return view('admin.store_rating.index',compact('data','access_type'));
    }

    public function show($id, StoreRating $store_rating)
    {
        abort_unless(in_array('view',$this->access_type), 403);
        $data = $store_rating->find($id);
        return view('admin.store_rating.view',compact('data'));
    }

    public function destroy($id, StoreRating $store_rating)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $store_rating = $store_rating->find($id);

        // delete data
        $store_rating->delete();

        // set message and redirect
        session()->flash('success','StoreRating deleted successfully.');
        return redirect()->route('admin::store_review');
    }


    public function change_status($id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        StoreRating::find($id)->update(['approve'=>$type]);

        // set message and redirect
        session()->flash('success','Review has been approved successfully.');
        return redirect()->route('admin::store_review');
    }
}
