<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Mail\OtpEmail;
use App\Helper\JWTToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ThirdTaskController extends Controller
{
    public function userRegistration(Request $request){
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:5|confirmed',
            ]);
            // dd($request->all());
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);
            if ($user) {
                $token = JWTToken::createToken($user->email);
                return response()->json([
                    'status' => 'success',
                    'message' => 'User registered successfully',
                    'token' => $token,
                ]);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'User registration failed',
                ]);
            }
            
    }

    public function userLogin(Request $request){
        // dd($request);
        $request->validate([
            'login_email' => 'required|string|email|max:255',
            'login_password' => 'required|string|min:5',
        ]);
        $count = User::where('email', '=', $request->login_email)
            ->where('password', '=', $request->login_password)
            ->count();

        if ($count == 1) {
            $token = JWTToken::createToken($request->email);
            return response()->json([
                'status' => 'success',
                'message' => 'User login successfully',
                'token' => $token,
            ]);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'User login failed',
            ]);
        }
    }
    public function sendOTPCode(Request $request)
    {
        $email = $request->email;
        $otp = rand(1111, 9999);
        $count = User::where('email', '=', $email)->count();
        if ($count) {
            User::where('email', '=', $email)->update([
                "otp" => $otp,
            ]);
            # OTP send via email
            Mail::to($email)->send(new OtpEmail($otp));
            return redirect()->route('enterotp');
        }
    }
    public function VerifyOTP(Request $request)
    {
        $email = $request->email;
        $otp = $request->otp;
        $count = User::where('email', '=', $email)
            ->where('otp', '=', $otp)
            ->count();

        if ($count == 1) {
            // database OTP update
            User::where('email', '=', $email)->update([
                "otp" => "0",
            ]);
            $token = JWTToken::createTokenForSetPassword($request->email);
            return response()->json([
                'status' => 'success',
                'message' => 'OTP verification successfull',
                'token' => $token,
            ]);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Unauthorized',
            ]);
        }
    }
}
