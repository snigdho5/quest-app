<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\AdminModels\EntrySlots;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EntrySlotsController extends Controller
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
        $data = EntrySlots::all();
        return view('admin.entry_slots.index',compact('data','access_type'));
    }

    public function store(Request $request)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'slot_start' => 'required',
            'slot_end' => 'required',
            'active' => 'required',
        ]);

        request()->merge(['slot_start'=> date('H:i:s',strtotime(date('Y-m-d ').request()->slot_start)) ]);
        request()->merge(['slot_end'=> date('H:i:s',strtotime(date('Y-m-d ').request()->slot_end)) ]);


        if (strtotime(date('Y-m-d ').request()->slot_start) >= strtotime(date('Y-m-d ').request()->slot_end)) {
            return back()->withErrors(['ee'=>'End time should be greater than Start time.'])->withInput();
        }

        $entry = EntrySlots::where(function ($query) {
                                $query->where('slot_start', '<=', request()->slot_start)
                                      ->where('slot_end', '>=', request()->slot_start);
                            })->orWhere(function ($query) {
                                $query->where('slot_start', '<=', request()->slot_end)
                                      ->where('slot_end', '>=', request()->slot_end);
                            })->orWhereBetween('slot_start',[request()->slot_start,request()->slot_end])
                            ->orWhereBetween('slot_end',[request()->slot_start,request()->slot_end]);
                            

        if($entry->count() > 0){
            return back()->withErrors(['ee'=>'Entry slot '.date('h:i a',strtotime(request()->slot_start)).' to '.date('h:i a',strtotime(request()->slot_end)) . ' is overlapping with existing slots.'])->withInput();
        }

        // insert into database
        EntrySlots::create(request()->all());

        // set message and redirect
        session()->flash('success','Entry slot added successfully.');
        return redirect()->route('admin::entrySlots');
    }

    public function destroy($id, EntrySlots $entrySLots)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $entrySLots = $entrySLots->find($id);

        // delete data
        $entrySLots->delete();

        // set message and redirect
        session()->flash('success','Entry slot deleted successfully.');
        return redirect()->route('admin::entrySlots');
    }

    public function change_status($id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        EntrySlots::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','Entry slot status changed successfully.');
        return redirect()->route('admin::entrySlots');
    }
}
