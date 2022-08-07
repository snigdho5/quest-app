<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
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
        $data = Feedback::all();
        return view('admin.feedback.index',compact('data','access_type'));
    }

    public function show($id, Feedback $feedback)
    {
        abort_unless(in_array('view',$this->access_type), 403);
        $data = $feedback->find($id);
        return view('admin.feedback.view',compact('data'));
    }

    public function destroy($id, Feedback $feedback)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $feedback = $feedback->find($id);

        // delete data
        $feedback->delete();

        // set message and redirect
        session()->flash('success','Feedback deleted successfully.');
        return redirect()->route('admin::feedback');
    }


    public function change_status($id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        Feedback::find($id)->update(['approve'=>$type]);

        // set message and redirect
        session()->flash('success','Review has been approved successfully.');
        return redirect()->route('admin::feedback');
    }
}
