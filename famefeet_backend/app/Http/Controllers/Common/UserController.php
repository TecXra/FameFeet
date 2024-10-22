<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Fan;
use App\Models\Celebrity;
use App\Models\PersonalInformation;
use Illuminate\Support\Facades\DB;
use Psy\VersionUpdater\Checker;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function getAuthenticateUser()
    {
        $user = Auth::user();
        if($user->account_status != config('famefeet.account_status.active')){
            return response()->json([
                'message' => 'your account is disabled, Contect to our support team'
            ], 403);
        }
        if ($user->user_type == config('famefeet.user_type.fan')){
            $user->fan;
            if($user->date_of_birth == null || $user->phone_number == null){
                $user->is_profile_completed = false;
            }else{
                $user->is_profile_completed = true;
            }
            if($user->email_verified_at == null){
                $user->is_email_verified = false;
            }else{
                $user->is_email_verified = true;
            }
            if($user->password == null){
                $user->password_unset = false;
            }else{
                $user->password_unset = true;
            }
            return $user;
        }elseif($user->user_type == config('famefeet.user_type.celebrity')){
            $user->celebrity;
            if($user->email_verified_at == null){
                $user->is_email_verified = false;
            }else{
                $user->is_email_verified = true;
            }
            if($user->password == null){
                $user->password_unset = false;
            }else{
                $user->password_unset = true;
            }
            if($user->date_of_birth == null || $user->phone_number == null || $user->celebrity->gender == null
            || $user->celebrity->avatar = null || $user->celebrity->like == null || $user->celebrity->dislike == null || $user->celebrity->bio == null
            || $user->celebrity->messages == null || $user->celebrity->feet_id == null
            || $user->celebrity->send_offer == null || $user->celebrity->profession_id == null
            || $user->celebrity->fun_fact == null){
                $user->is_profile_completed = false;
            }else{
                $user->is_profile_completed = true;
            }
            return $user;
        }else{
            return $user;
        }

    }
}
