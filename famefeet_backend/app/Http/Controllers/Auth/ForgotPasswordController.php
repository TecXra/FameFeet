<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use App\Models\User;
use App\Notifications\ForgotPasswordNotification;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Delight\Random\Random;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    //use SendsPasswordResetEmails;
    //Email verification for forget Password
    public function forgetPassword(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'email' => 'required|email|regex:/^[^\.]+(\.[^\.]+)*@[^\.]+\.[^\.]+$/',
        ]);
        if($validation->fails()){
            return response()->json($validation->errors(),400);
        }
        try {
            //Get User
            $user = User::where('email',$request->email)->get();
            if(count($user) > 0){
                $token = Random::alphanumericHumanString(6);

                Notification::send($user,new ForgotPasswordNotification($user,$token));

                $datetime = Carbon::now()->format('Y-m-d H:i:s');
                PasswordReset::updateOrCreate(
                   ['email' => $request->email],
                   [
                    'email' => $request->email,
                    'token' => $token,
                    'created_at' => $datetime
                    ]
                );
             return response()->json([
                'message' => 'Please check your email for verification code!',
             ]);
            }else{
                return response()->json([
                    'message' => ['Please enter a valid email address!'],
                ],400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }

    // Pass forget password user info to the view
    public function varifyToken(Request $request)
    {
        $updatePassword =DB::table('password_resets')
                        ->where('token',$request->token)->first();
        // return $updatePassword;
            if(isset($updatePassword)){
                   return $updatePassword;
            }else{
                return response()->json([
                    'message' => ['Please enter correct verification code!'],
                ],400);
            }

    }
    // Forget Password
    public function resetForgetPassword(Request $request){
        // return $request;
        $validation = Validator::make($request->all(),[
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6|same:password'
        ]);
        if($validation->fails()){
            return response()->json($validation->errors(),400);
        }

        $updatePassword =DB::table('password_resets')
                        ->where('token',$request->token)->first();
            // return ;
            if(isset($updatePassword) == 1){
            $user = User::where('email',$updatePassword->email)->first();
            // return $user;

                $user->password =  Hash::make($request->password);
                $user->save();
                PasswordReset::where('token',$request->token)->delete();

                return response()->json([
                    'message'=>'Password reset successfully!'
                ]);
            }else{
                return response()->json([
                    'message'=>['Something Wrong!']
                ],400);
                // return Redirect::back()->with('message','Invalid Token..!');
            }
    }
}
