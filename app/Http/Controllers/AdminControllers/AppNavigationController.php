<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\AdminModels\Cms;
use App\Models\AdminModels\AppNavigation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AppNavigationController extends Controller {
	private $uploadPath = 'app_navigation/actual/';
	private $uploadPath_meta = 'link_data/';
	protected $access_type;

	public function __construct() {
		$this->middleware('auth:admin');
		$this->middleware(function ($request, $next) {
			$this->access_type = checkAccess(auth()->guard('admin')->user()->role);
			if (count($this->access_type) == 0) {
				abort(403);
			}

			return $next($request);
		});
	}

	public function index() {
		$access_type = $this->access_type;
		$data = AppNavigation::all();
		return view('admin.app_navigation.index', compact('data', 'access_type'));
	}

	public function create() {
		abort_unless(in_array('add', $this->access_type), 403);

        $cmsArr = Cms::get();
		return view('admin.app_navigation.create',compact('cmsArr'));
	}

	public function store(Request $request) {
		abort_unless(in_array('add', $this->access_type), 403);
		// validation
		$this->validate(request(), [
			'title' => 'required',
			'icon'  =>'required',
			'active' => 'required',
		]);

		// ordering funtionality
		request()->merge(['priority' => AppNavigation::all()->count() + 1]);

		

		// insert into database
		AppNavigation::create(request()->all());

		// set message and redirect
		session()->flash('success', 'AppNavigation added successfully.');
		return redirect()->route('admin::app_navigation');
	}

	public function edit($id, AppNavigation $app_navigation) {
		abort_unless(in_array('edit', $this->access_type), 403);
		$data = $app_navigation->find($id);

        $cmsArr = Cms::get();
		return view('admin.app_navigation.edit', compact('data','cmsArr'));
	}

	public function update($id, Request $request, AppNavigation $app_navigation) {
		abort_unless(in_array('edit', $this->access_type), 403);
		// validation
		$this->validate(request(), [
			'title' => 'required',
			'icon'  =>'required',
			'active' => 'required',
		]);

		$app_navigation = $app_navigation->find($id);

		
		// update database
		$app_navigation->update(request()->all());
		$app_navigation->save();

		// set message and redirect
		session()->flash('success', 'AppNavigation updated successfully.');
		return redirect()->route('admin::app_navigation');
	}

	public function destroy($id, AppNavigation $app_navigation) {
		abort_unless(in_array('delete', $this->access_type), 403);
		$app_navigation = $app_navigation->find($id);

		// reset priority
		AppNavigation::resetOrder($app_navigation->priority, '');

		

		// delete data
		$app_navigation->delete();

		// set message and redirect
		session()->flash('success', 'AppNavigation deleted successfully.');
		return redirect()->route('admin::app_navigation');
	}

	public function change_status($id, $type) {
		abort_unless(in_array('status', $this->access_type), 403);
		AppNavigation::find($id)->update(['active' => $type]);

		// set message and redirect
		session()->flash('success', 'Status changed successfully.');
		return redirect()->route('admin::app_navigation');
	}

	public function order(Request $request) {
		abort_unless(in_array('order', $this->access_type), 403);
		$oldOrder = intVal(AppNavigation::find(request()->id)->priority);
		$newOrder = intVal(request()->o);

		if ($oldOrder < $newOrder) {
			AppNavigation::where([['priority', '>', $oldOrder], ['priority', '<=', $newOrder]])->decrement('priority', 1);
		} else {
			AppNavigation::where([['priority', '<', $oldOrder], ['priority', '>=', $newOrder]])->increment('priority', 1);
		}

		AppNavigation::find(request()->id)->update(['priority' => request()->o]);

		// set message and redirect
		session()->flash('success', 'AppNavigation order changed successfully.');
		return redirect()->route('admin::app_navigation');
	}

}
