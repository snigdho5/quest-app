<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminModels\Query;

class QueryController extends Controller
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
        $data = Query::all();
        return view('admin.query.index',compact('data','access_type'));
    }

    public function show($id, Query $query)
    {
        abort_unless(in_array('view',$this->access_type), 403);
        $data = $query->find($id);
        return view('admin.query.view',compact('data'));
    }

    public function destroy($id, Query $query)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $query = $query->find($id);

        // delete data
        $query->delete();

        // set message and redirect
        session()->flash('success','Query deleted successfully.');
        return redirect()->route('admin::query');
    }
}
