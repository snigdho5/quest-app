<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Helpers;

class UserController extends Controller
{
    //  
    function index(Request $request)
    {
        return response('Access Resticted!', 401);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required|numeric',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => 'Validation problem!',
                'respData' => Helpers::error_processor($validator)
            ], 401);
        }

        $user = User::where('email', $request->email)->orWhere('phone', $request->phone)->first();
        // print_r($user);die;
        if (!$user) {

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->save();

            return response([
                'status' => 1,
                'message' => 'Sign up successful!',
            ], 200);
        } else {
            return response([
                'status' => 0,
                'message' => 'User already exists!',
                'user' => $user,
            ], 200);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => 'Validation problem!',
                'respData' => Helpers::error_processor($validator)
            ], 401);
        }

        $user = User::where('email', $request->email)->first();
        // print_r($user);die;
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'status' => 0,
                'message' => 'These credentials do not match our records.'
            ], 404);
        }

        $token = $user->createToken('my-app-token')->plainTextToken;

        $response = [
            'status' => 1,
            'user' => $user,
            'token' => $token
        ];

        return response($response, 200);
    }

    public function otpLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric|digits:10'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => 'Validation problem!',
                'respData' => Helpers::error_processor($validator)
            ], 401);
        }

        $otp = rand(1000, 9999);
        $user = User::where('phone', $request->phone)->first();
        // print_r($user);die;
        if (!$user) {
            $user = new User();
            $user->name = '';
            $user->email = Helpers::generateRandomString() . '@gmail.com';
            $user->phone = $request->phone;
            $user->password = Hash::make($request->phone);
            $user->save();
            $new_user = TRUE;

            // return response([
            //     'status' => 0,
            //     'message' => 'The entered phone number does not match our records!'
            // ], 404);
        } else {
            $new_user = FALSE;
        }

        // Log::info(message: "otp" . $otp);

        $userUpdate = User::where('phone', $request->phone)
            ->update([
                'otp_verified' => 0,
                'otp' => $otp,
                'lastlogin' => now()
            ]);


        $user = User::where('phone', $request->phone)->first();

        $response = [
            'status' => 1,
            'message' => 'OTP sent!',
            'is_new_user' => $new_user,
            'user' => $user
        ];

        return response()->json($response, 200);
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response([
            'status' => 1,
            'message' => 'Successfully Logged out!',
        ], 200);
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric|digits:10',
            'otp' => 'required|numeric|digits:4'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => 'Validation problem!',
                'respData' => Helpers::error_processor($validator)
            ], 401);
        }

        $user = User::where([
            'phone' => $request->phone,
            'otp' => $request->otp,
            'otp_verified' => 0
        ])->first();

        if (!$user) {
            return response([
                'status' => 0,
                'message' => 'OTP is incorrect!'
            ], 404);
        }


        $token = $user->createToken('my-app-token')->plainTextToken;

        $userUpdate = User::where('phone', $request->phone)
            ->update([
                'otp_verified' => 1,
                'token' => $token
            ]);

        $user = User::where('phone', $request->phone)->first();

        $response = [
            'status' => 1,
            'message' => 'OTP verified!',
            'user' => $user
        ];

        return response($response, 200);
    }

    public function updateUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric|digits:10',
            'name' => 'required',
            'file' => 'required|mimes:jpg,png,jpeg|max:2048'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => 'Validation problem!',
                'respData' => Helpers::error_processor($validator)
            ], 401);
        }

        $user = User::where([
            'phone' => $request->phone
        ])->first();

        if (!$user) {
            return response([
                'status' => 0,
                'message' => 'User not found!'
            ], 404);
        }

        if ($request->file()) {
            $fileName = time() . '_' . $request->file->getClientOriginalName();
            $request->file->move(public_path('uploads'), $fileName);
        }

        $userUpdate = User::where('phone', $request->phone)
            ->update([
                'kyc_updated' => 1,
                'name' => $request->name,
                'year_of_birth' => $request->year_of_birth,
                'gender' => $request->gender,
                'file_path' => url('public/uploads/' . $fileName)
            ]);

        $user = User::where('phone', $request->phone)->first();

        $response = [
            'status' => 1,
            'message' => 'User updated!',
            'user' => $user
        ];

        return response($response, 200);
    }
}
