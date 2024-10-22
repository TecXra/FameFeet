<?php

namespace Services;
use App\Models\User;
use App\Models\VerifyUser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserStatusService
{
    public static function updateUserStatus($request,$user)
    {
        $user->account_status = $request->account_status;
        $user->save();
        if($request->account_status == config('famefeet.account_status.active'))
        {
            $user->restore();
        }
        return $user;
        //  if($data->account_status == config('famefeet.account_status.active')){
        //  $status = config('famefeet.account_status.suspend');
        //   }else{
        //   $status = config('famefeet.account_status.active');
        //   }
        //   return $data = array('account_status' => $status);
    }

    public static function varifyUserEmail($user){
       $verifyUser  = new VerifyUser();
       $verifyUser->token = Str::random(40);
       $verifyUser->email = $user->email;
       $verifyUser->user_id = $user->id;
       $verifyUser->save();
       return $verifyUser;
    }
}
