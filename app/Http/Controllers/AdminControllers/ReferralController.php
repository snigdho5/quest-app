<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminModels\Refferal;

class ReferralController extends Controller
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
        $data = Refferal::all();
        return view('admin.refferal.index',compact('data','access_type'));
    }

    public function show($id, Refferal $refferal)
    {
        abort_unless(in_array('view',$this->access_type), 403);
        $data = $refferal->find($id);
        return view('admin.refferal.view',compact('data'));
    }

    public function destroy($id, Refferal $refferal)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $refferal = $refferal->find($id);

        // delete data
        $refferal->delete();

        // set message and redirect
        session()->flash('success','Refferal deleted successfully.');
        return redirect()->route('admin::refferal');
    }
}
