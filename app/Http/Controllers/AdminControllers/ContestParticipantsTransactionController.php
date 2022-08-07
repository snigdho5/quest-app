<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminModels\ContestParticipantTransaction;

class ContestParticipantsTransactionController extends Controller
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
        $data = ContestParticipantTransaction::all();
        return view('admin.contest_participants_transaction.index',compact('data','access_type'));
    }

    public function show($id, ContestParticipantTransaction $query)
    {
        abort_unless(in_array('view',$this->access_type), 403);
        $data = $query->find($id);
        return view('admin.contest_participants_transaction.view',compact('data'));
    }

    public function destroy($id, ContestParticipantTransaction $query)
    {
        abort_unless(in_array('delete',$this->access_type), 403);
        $query = $query->find($id);

        // delete data
        $query->delete();

        // set message and redirect
        session()->flash('success','Contest Participant Transaction deleted successfully.');
        return redirect()->route('admin::contest_participants_transaction');
    }
}
