<?php

namespace App\Http\Controllers\AppApiControllers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

use App\Models\User;
use App\Models\AdminModels\EntrySettings;
use App\Models\AdminModels\EntrySlots;
use App\Models\AdminModels\EntryBooking;

class BookingController extends Controller
{
    public function __construct(){

    }

    public function getInfo(){
        request()->merge(['token' => Crypt::decryptString(request()->token)]);
        request()->merge(['user_id' => Crypt::decryptString(request()->user_id)]);

        // validation
        $validator = Validator::make(request()->all(),[
            'token' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return Crypt::encryptString(json_encode(array("error"=>"Invalid token.")));
        }
        else{
            $user = User::where([['token',request()->token],['id',request()->user_id]]);
            if ($user->count()) {
                $data = EntrySettings::all()->toArray();

                $booking = EntryBooking::where([['user_id',request()->user_id],['status','>',0]])->whereDate('date','>=',date('Y-m-d'))->orderBy('id','desc')->get();

                if ($booking->count() > 0){
                    if($booking->first()->date == date('Y-m-d') && strtotime(date('Y-m-d ') . $booking->first()->slot_end) > time()){
                        $booking = $booking->toArray();
                    }else if($booking->first()->date != date('Y-m-d')) $booking = $booking->toArray();
                    else $booking = [];

                }else $booking = [];

                echo Crypt::encryptString(json_encode($data).json_encode($booking));
            }else return Crypt::encryptString(json_encode(array("error"=>"Invalid token.")));
        }
    }

    public function cancelBooking(){
        request()->merge(['token' => Crypt::decryptString(request()->token)]);
        request()->merge(['user_id' => Crypt::decryptString(request()->user_id)]);

        // validation
        $validator = Validator::make(request()->all(),[
            'token' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return Crypt::encryptString(json_encode(array("error"=>"Invalid token.")));
        }
        else{
            $user = User::where([['token',request()->token],['id',request()->user_id]]);
            if ($user->count()) {

                $booking = EntryBooking::where([['user_id',request()->user_id],['status',1]])->whereDate('date','>',date('Y-m-d'))->orderBy('id','desc');

                if ($booking->count() > 0){
                    $booking->first()->update(['status'=>0]);
                    echo 1;
                    
                }else echo 0;

            }else return Crypt::encryptString(json_encode(array("error"=>"Invalid token.")));
        }
    }

    public function getSlots(){
        request()->merge(['token' => Crypt::decryptString(request()->token)]);
        request()->merge(['user_id' => Crypt::decryptString(request()->user_id)]);
        request()->merge(['date' => Crypt::decryptString(request()->date)]);

        // validation
        $validator = Validator::make(request()->all(),[
            'token' => 'required',
            'user_id' => 'required',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return Crypt::encryptString(json_encode(array("error"=>"Invalid token.")));
        }
        else{
            $user = User::where([['token',request()->token],['id',request()->user_id]]);
            if ($user->count()) {
                $data = EntrySlots::select('slot_start','slot_end')->where('active','1')->get()->toArray();

                foreach ($data as $key => $value) {
                    $booking = EntryBooking::where([['slot_start',$value['slot_start']],['slot_end', $value['slot_end']],['status','>',0]])->whereDate('date',request()->date);

                    $data[$key]['booking'] = $booking->count() + $booking->sum('child');
                }

                echo Crypt::encryptString(json_encode($data));
            }else return Crypt::encryptString(json_encode(array("error"=>"Invalid token.")));
        }
    }

    public function bootEntry(Request $request){
        request()->merge(['token' => Crypt::decryptString(request()->token)]);
        request()->merge(['user_id' => Crypt::decryptString(request()->user_id)]);
        request()->merge(['date' => Crypt::decryptString(request()->date)]);
        request()->merge(['slot' => Crypt::decryptString(request()->slot)]);
        request()->merge(['child' => Crypt::decryptString(request()->child)]);
        request()->merge(['image' => Crypt::decryptString(request()->image)]);
        request()->merge(['event_id' => Crypt::decryptString(request()->event_id)]);

        // validation
        $validator = Validator::make(request()->all(),[
            'token' => 'required',
            'user_id' => 'required',
            'date' => 'required|date',
            'slot' => 'required',
            'child' => 'required',
            'event_id' => 'required',
            'image' => 'required',
        ]);

        if ($validator->fails()) {
            return Crypt::encryptString(json_encode(array("error"=>"Invalid token.")));
        }
        else{
            $user = User::where([['token',request()->token],['id',request()->user_id]]);
            if ($user->count()) {
                $booking = EntryBooking::where([['user_id',request()->user_id],['status','>',0]])->whereDate('date','>=',request()->date);
                if($booking->count() == 0){
                    $slots = EntrySlots::where('slot_start',date("H:i:s",strtotime(explode(" - ",request()->slot)[0])))
                                        ->where('slot_end',date("H:i:s",strtotime(explode(" - ",request()->slot)[1])))
                                        ->where('active','1');

                    if($slots->count() > 0){
                        request()->merge(['slot_id' => $slots->first()->id]);
                        request()->merge(['slot_start' => $slots->first()->slot_start]);
                        request()->merge(['slot_end' => $slots->first()->slot_end]);

                        $hash = hash("sha256", request()->date.request()->slot);
                        request()->merge(['entry_hash' => strtoupper(substr($hash, 0, 5))]);
                        $booking = EntryBooking::create(request()->all());
                        Storage::disk('public')->put('entrybooking/'.$booking->id.'.jpg', \Image::make(request()->image)->encode('jpg')->__toString(),"public");
                        return Crypt::encryptString(0);                  
                    }else return Crypt::encryptString(1); 


                }else return Crypt::encryptString(0);
            }else return Crypt::encryptString(json_encode(array("error"=>"Invalid token.")));
        }
    }

    public function logEntry(){
        request()->merge(['token' => Crypt::decryptString(request()->token)]);
        request()->merge(['user_id' => Crypt::decryptString(request()->user_id)]);

        // validation
        $validator = Validator::make(request()->all(),[
            'token' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return Crypt::encryptString(json_encode(array("error"=>"Invalid token.")));
        }
        else{
            $user = User::where([['token',request()->token],['id',request()->user_id]]);
            if ($user->count()) {
                $booking = EntryBooking::where([['user_id',request()->user_id],['status',1]])->whereDate('date',date('Y-m-d'))->whereTime('slot_end','>',date('H:i:s'));
                if ($booking->count() == 1){
                    $booking->update(['status'=>2]);
                    echo 1;
                }else echo 0;
            }else return Crypt::encryptString(json_encode(array("error"=>"Invalid token.")));
        }
    }

    public function logExit(){
        request()->merge(['token' => Crypt::decryptString(request()->token)]);
        request()->merge(['user_id' => Crypt::decryptString(request()->user_id)]);

        // validation
        $validator = Validator::make(request()->all(),[
            'token' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return Crypt::encryptString(json_encode(array("error"=>"Invalid token.")));
        }
        else{
            $user = User::where([['token',request()->token],['id',request()->user_id]]);
            if ($user->count()) {
                $booking = EntryBooking::where([['user_id',request()->user_id],['status',2]])->whereDate('date',date('Y-m-d'))->whereTime('slot_end','>',date('H:i:s'));
                if ($booking->count() == 1){
                    $booking->update(['status'=>-1]);
                    echo 1;
                }else echo 0;
            }else return Crypt::encryptString(json_encode(array("error"=>"Invalid token.")));
        }
    }


}
