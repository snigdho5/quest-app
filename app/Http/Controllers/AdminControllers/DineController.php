<?php

namespace App\Http\Controllers\AdminControllers;


use App\Models\AdminModels\StoreContactNo;
use App\Models\AdminModels\StoreContactEmail;
use App\Models\AdminModels\Store;
use App\Models\AdminModels\StoreCategory;
use App\Models\AdminModels\StoreType;
use App\Models\AdminModels\DineCuisine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class DineController extends Controller
{
    private $uploadPath = 'store/actual/';
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
        $data = Store::where('s_type','dine')->get();
        return view('admin.dine.index',compact('data','access_type'));
    }


    public function create()
    {
        abort_unless(in_array('add',$this->access_type), 403);
        $category = StoreCategory::where([['type','dine']])->get();
        $cuisine = DineCuisine::where('active',1)->get();
        $data = StoreType::where([['type','dine']])->get();
        return view('admin.dine.create',compact('data','category','cuisine'));
    }

    public function store(Request $request)
    {
        abort_unless(in_array('add',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'name' => 'required|unique:store,name',
            'meta_imagefile' => 'image|mimes:jpeg,png,jpg|max:1024',
            'logofile' => 'required|image|mimes:jpeg,png,jpg|max:4096',
            'locationfile'=> 'required|image|mimes:jpeg,png,jpg|max:4096',
            'description' => 'required',
            'category_id'=> 'array',
            'type_id'=> 'required',
            'floor'=> 'required',
            'manager'=> 'required',
            'timing'=> 'required',
            'store_phones'=> 'required',
            'manager_phone'=> 'required',
            'cuisine'=> 'required|array',
            'menu'=> request()->menu?'url':'',
            'review'=> request()->review?'url':'',
            'post_time' => 'required',
            'active' => 'required',
        ]);

        if(request()->cuisine) request()->merge(['cuisine' => implode(',',request()->cuisine)]);
        if(request()->category_id) request()->merge(['category_id' => implode(',',request()->category_id)]);
        else request()->merge(['category_id' => ""]);
        request()->merge(['s_type' => 'dine']);
        request()->merge(['login_id' => rand(10000,99999)]);

        // fileupload
        $image = request()->logofile;
        $imagename = filterFileName($image);
        if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
            return back()->withErrors(['logofile'=>'Cannot upload to server.']);
        }
        request()->merge(['logo' => $imagename]);

        $image = request()->locationfile;
        $imagename = filterFileName($image);
        if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
            return back()->withErrors(['locationfile'=>'Cannot upload to server.']);
        }
        request()->merge(['location' => $imagename]);

        if (request()->hasFile('meta_imagefile')) {
            $image = request()->meta_imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath_meta, $imagename)==false){
                return back()->withErrors(['meta_imagefile'=>'Cannot upload to server.']);
            }
            request()->merge(['meta_image' => $imagename]);
        }

        // insert into database
        $store = Store::create(request()->all());


        foreach (request('store_phones') as $key=>$value) {
            StoreContactNo::create(['store_id'=>$store->id,'phone'=>$value,'primary'=>($key==request('primaryPhone')?'1':'0')]);
        }

        if(request('emails')){
            foreach (request('emails') as $key=>$value) {
                StoreContactEmail::create(['store_id'=>$store->id,'email'=>$value,'primary'=>($key==request('primaryEmail')?'1':'0')]);
            }
        }

        // set message and redirect
        session()->flash('success','Dine added successfully.');
        return redirect()->route('admin::dine');
    }

    public function edit($id, Store $store)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        $data = $store->find($id);
        $category = StoreCategory::where([['type','dine']])->get();
        $cuisine = DineCuisine::where('active',1)->get();
        $type = StoreType::where([['type','dine']])->get();
        return view('admin.dine.edit',compact('data','category','type','cuisine'));
    }

    public function update($id, Request $request, Store $store)
    {
        abort_unless(in_array('edit',$this->access_type), 403);
        // validation
        $this->validate(request(),[
            'name' => ['required',Rule::unique('store')->ignore($id)],
            'meta_imagefile' => 'image|mimes:jpeg,png,jpg|max:1024',
            'logofile' => 'image|mimes:jpeg,png,jpg|max:4096',
            'locationfile'=> 'image|mimes:jpeg,png,jpg|max:4096',
            'description' => 'required',
            'category_id'=> 'array',
            'type_id'=> 'required',
            'floor'=> 'required',
            'manager'=> 'required',
            'timing'=> 'required',
            'store_phones'=> 'required',
            'manager_phone'=> 'required',
            'cuisine'=> 'required|array',
            'menu'=> request()->menu?'url':'',
            'review'=> request()->review?'url':'',
            'post_time' => 'required',
            'active' => 'required',
        ]);

        if(request()->category_id) request()->merge(['category_id' => implode(',',request()->category_id)]);
        if(request()->cuisine) request()->merge(['cuisine' => implode(',',request()->cuisine)]);
        else request()->merge(['category_id' => ""]);
        request()->merge(['s_type' => 'dine']);

        $store = $store->find($id);

        // fileupload
        if (request()->hasFile('logofile')) {
            $image = request()->logofile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
                return back()->withErrors(['logofile'=>'Cannot upload to server.']);
            }
            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath.$store->logo);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$store->logo);

            request()->merge(['logo' => $imagename]);
        }

        if (request()->hasFile('locationfile')) {
            $image = request()->locationfile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath, $imagename)==false){
                return back()->withErrors(['locationfile'=>'Cannot upload to server.']);
            }
            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath.$store->location);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$store->location);

            request()->merge(['location' => $imagename]);
        }

        if (request()->hasFile('meta_imagefile')) {
            $image = request()->meta_imagefile;
            $imagename = filterFileName($image);
            if($image->storePubliclyAs($this->uploadPath_meta, $imagename)==false){
                return back()->withErrors(['meta_imagefile'=>'Cannot upload to server.']);
            }
            // delete old file
            $old_file = Storage::disk('public')->path($this->uploadPath_meta.$store->meta_image);
            if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_meta.$store->meta_image);

            request()->merge(['meta_image' => $imagename]);
        }

        // update database
        $store->update(request()->all());
        $store->save();


        StoreContactNo::where('store_id',$store->id)->delete();

        foreach (request('store_phones') as $key=>$value) {
            StoreContactNo::create(['store_id'=>$store->id,'phone'=>$value,'primary'=>($key==request('primaryPhone')?'1':'0')]);
        }



        StoreContactEmail::where('store_id',$store->id)->delete();

        if(request('emails')){
            foreach (request('emails') as $key=>$value) {
                StoreContactEmail::create(['store_id'=>$store->id,'email'=>$value,'primary'=>($key==request('primaryEmail')?'1':'0')]);
            }
        }

        // set message and redirect
        session()->flash('success','Dine updated successfully.');
        return redirect()->route('admin::dine');
    }

    public function destroy($id, Store $store)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $store = $store->find($id);

        // delete file
        $old_file = Storage::disk('public')->path($this->uploadPath.$store->logo);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$store->logo);
        $old_file = Storage::disk('public')->path($this->uploadPath.$store->location);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath.$store->location);
        $old_file = Storage::disk('public')->path($this->uploadPath_meta.$store->meta_image);
        if(is_file($old_file)) Storage::disk('public')->delete($this->uploadPath_meta.$store->meta_image);


        StoreContactNo::where('store_id',$store->id)->delete();
        StoreContactEmail::where('store_id',$store->id)->delete();

        // delete data
        $store->delete();

        // set message and redirect
        session()->flash('success','Dine deleted successfully.');
        return redirect()->route('admin::dine');
    }

    public function change_status($id,$type)
    {
        abort_unless(in_array('status',$this->access_type), 403);
        Store::find($id)->update(['active'=>$type]);

        // set message and redirect
        session()->flash('success','Dine status changed successfully.');
        return redirect()->route('admin::dine');
    }
}
