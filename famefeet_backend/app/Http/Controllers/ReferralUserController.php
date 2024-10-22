<?php

namespace App\Http\Controllers;

use App\Models\ReferUser;
use Illuminate\Support\Facades\Auth;

class ReferralUserController extends Controller
{
    //
//     public function changeReferralStatus(){
//         $referUsers = ReferUser::where('is_expired',false)
//                 ->where('expire_date','<=', Carbon::now()->toDateTimeString())
//                 ->get();
//         // return $referUsers;
//         foreach ($referUsers as $referUser) {
//               $referUser->is_expired = true;
//               $referUser->save();
//         }
//         return true;

//    }

    public function getReferUsersOfCelebrity(){
           $referUsers = ReferUser::query()->with(['user' => function ($query) {
                  $query->withTrashed()->select('id', 'username','avatar','user_type','account_status');
              }])->where("referred_user_id",Auth::user()->id)->get();
           return $referUsers;
    }
}
