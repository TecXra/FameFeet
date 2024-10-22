<?php
namespace Services;

use App\Models\ReferUser;
use Illuminate\Support\Carbon as SupportCarbon;

class ReferralUserService
{
   public static function saveReferralUserDetails($user_id,$referred_user_id){
       $referUser = new ReferUser();
       $referUser->referral_bonus_percentage = config('famefeet.referral_bonus_percentage');
       $referUser->referred_user_id = $referred_user_id;
       $referUser->expire_date = config('famefeet.referral_expire_date');
       $referUser->user_id = $user_id;

       $referUser->save();
   }

   public static function changeReferralStatus(){
        $referUsers = ReferUser::where('is_expired',false)
                ->where('expire_date','<=', SupportCarbon::now()->toDateTimeString())
                ->get();
        foreach ($referUsers as $referUser) {
              $referUser->is_expired = true;
              $referUser->save();
              
        }
        return true;
   }
}
