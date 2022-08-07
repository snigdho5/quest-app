<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\AdminModels\Admin;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    public function __construct(){
    	$this->middleware('auth:admin');
    }

    public function index(){
    	return view('admin.password');
    }

    public function update(Request $request, Admin $admin){
    	// validation
        $this->validate(request(),[
            'password' => 'required|confirmed'
        ]);
        request()->merge(['password' => bcrypt(request()->password)]);

        $admin = $admin->find(auth()->guard('admin')->user()->id);

        // update database
        $admin->update(request()->all());
        $admin->save();

        // set message and redirect
        session()->flash('success','Password updated successfully.');
        return redirect('admin::password');
    }
}
