<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminModels\QcardTransaction;

class QcardTransactionController extends Controller
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
        $data = QcardTransaction::all();
        return view('admin.qcard_transaction.index',compact('data','access_type'));
    }

    public function show($id, QcardTransaction $qcard_transaction)
    {
        abort_unless(in_array('view',$this->access_type), 403);
        $data = $qcard_transaction->find($id);
        return view('admin.qcard_transaction.view',compact('data'));
    }

    public function destroy($id, QcardTransaction $qcard_transaction)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $qcard_transaction = $qcard_transaction->find($id);

        // delete data
        $qcard_transaction->delete();

        // set message and redirect
        session()->flash('success','QcardTransaction deleted successfully.');
        return redirect()->route('admin::qcard_transaction');
    }
}
