<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\AdminModels\Qauthor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QauthorController extends Controller
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
        $data = Qauthor::all();
        return view('admin.qauthor.index',compact('data','access_type'));
    }


    public function create()
    {
        abort_unless(in_array('add',$this->access_type), 403);
        return view('admin.qauthor.create');
    }

    public function store(Request $request)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'active' => 'required',
        ]);

        // insert into database
        Qauthor::create(request()->all());

        // set message and redirect
        session()->flash('success','Tags added successfully.');
        return redirect()->route('admin::qauthor');
    }

    public function edit($id, Qauthor $qauthor)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $qauthor->find($id);
        return view('admin.qauthor.edit',compact('data'));
    }

    public function update($id, Request $request, Qauthor $qauthor)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'title' => 'required',
            'active' => 'required',
        ]);

        $qauthor = $qauthor->find($id);

        // update database
        $qauthor->update(request()->all());
        $qauthor->save();

        // set message and redirect
        session()->flash('success','Tags updated successfully.');
        return redirect()->route('admin::qauthor');
    }

    public function destroy($id, Qauthor $qauthor)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $qauthor = $qauthor->find($id);

        // delete data
        $qauthor->delete();

        // set message and redirect
        session()->flash('success','Tags deleted successfully.');
        return redirect()->route('admin::qauthor');
    }

    public function change_status($id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        Qauthor::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','Tags status changed successfully.');
        return redirect()->route('admin::qauthor');
    }
}
