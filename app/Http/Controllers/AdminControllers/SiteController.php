<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\AdminModels\SiteSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteController extends Controller
{
    private $uploadPath = 'logo_icon/';
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
        $data = SiteSettings::find(1);
        return view('admin.sitesettings',compact('data'));
    }

    public function update(Request $request, SiteSettings $sitesettings)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $this->validate(request(),[
            'title' => 'required',
            'flogo_file'  => 'image|mimes:png|max:4096',
            'logo_file'  => 'image|mimes:png|max:4096',
            'companylogo_file'   => 'image|mimes:png|max:4096',
            'login_back_file' => 'image|mimes:jpeg,jpg|max:4096',
            'favicon_file'   =>'image|mimes:png|max:512',
        ]);

        $sitesettings = $sitesettings->find(1);

        // fileupload
        if(request()->hasFile('logo_file')){
            $image = request()->logo_file;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
                return back()->withErrors(['logo_file'=>'Cannot upload to server.']);
            }

            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath.$sitesettings->logo);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$sitesettings->logo);

            request()->merge(['logo' => $imagename]);
        }

        if(request()->hasFile('flogo_file')){
            $image = request()->flogo_file;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
                return back()->withErrors(['flogo_file'=>'Cannot upload to server.']);
            }

            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath.$sitesettings->flogo);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$sitesettings->flogo);

            request()->merge(['flogo' => $imagename]);
        }

        if(request()->hasFile('companylogo_file')){
            $image = request()->companylogo_file;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
                return back()->withErrors(['companylogo_file'=>'Cannot upload to server.']);
            }

            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath.$sitesettings->companylogo);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$sitesettings->companylogo);

            request()->merge(['companylogo' => $imagename]);
        }

        if(request()->hasFile('login_back_file')){
            $image = request()->login_back_file;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
                return back()->withErrors(['login_back_file'=>'Cannot upload to server.']);
            }

            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath.$sitesettings->login_back);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$sitesettings->login_back);

            request()->merge(['login_back' => $imagename]);
        }

        if(request()->hasFile('favicon_file')){
            $image = request()->favicon_file;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
                return back()->withErrors(['favicon_file'=>'Cannot upload to server.']);
            }

            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath.$sitesettings->favicon);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$sitesettings->favicon);

            request()->merge(['favicon' => $imagename]);
        }

        // update database
        $sitesettings->update(request()->all());
        $sitesettings->save();

        // set message and redirect
        session()->flash('success','Site settings updated successfully.');
        return redirect()->route('admin::sitesettings');
    }

}
