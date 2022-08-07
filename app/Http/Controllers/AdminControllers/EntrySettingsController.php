<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\AdminModels\EntrySettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EntrySettingsController extends Controller
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
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = EntrySettings::find(1);
        return view('admin.entrysettings',compact('data'));
    }

    public function update(Request $request, EntrySettings $entrysettings)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $this->validate(request(),[
            'reminder_before' => 'required',
            'terms' => 'required',
            'active' => 'required',
            'slot_limit' => 'required',
        ]);

        $entrysettings = $entrysettings->find(1);

        // update database
        $entrysettings->update(request()->all());
        $entrysettings->save();

        // set message and redirect
        session()->flash('success','Entry settings updated successfully.');
        return redirect()->route('admin::entrysettings');
    }

}
