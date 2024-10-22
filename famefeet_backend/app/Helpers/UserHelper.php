<?php

use App\Models\Celebrity;
use App\Models\ReferUser;
use App\Models\ServiceCharges;
use App\Models\Shop;
use Illuminate\Support\Carbon;
use App\Models\User;



if (!function_exists('getUserById'))
{
    function getUserById($userId) {
        $user = User::find($userId);
        if(isset($user)){
            return $user;
        }
        return null;
    }
}



if (!function_exists('getCelebrityByUserId'))
{
    function getCelebrityByUserId($user_id) {
        $celeb = Celebrity::where('user_id',$user_id)->first();
        if(isset($celeb)){
            return $celeb;
        }
        return null;
    }
}


if (!function_exists('getCelebrityById'))
{
    function getCelebrityById($celeb_id) {
        $celeb = Celebrity::find($celeb_id);
        if(isset($celeb)){
            return $celeb;
        }
        return null;
    }
}


if (!function_exists('getUserTypeNameByUserType'))
{
	function getUserTypeNameByUserType($user_type) {
		foreach (config('famefeet.user_types') as $key => $value) {
            if($value['id'] == $user_type){
                return $value['name'];
            }
        }
        return null;
	}
}

if (!function_exists('getReviewTypeName'))
{
	function getReviewTypeName($review_type) {
		foreach (config('famefeet.review_types') as $key => $value) {
            if($value['id'] == $review_type){
                return $value['name'];
            }
        }
        return null;
	}
}


if(!function_exists('serviceChargesOfFamefeet'))
{
    function serviceChagesOfFamefeet($coins)
    {
        $charges = ServiceCharges::first();
        $charges_percentage = $charges->service_charges / 100 ;
        return $charges_percentage * $coins;
    }
}

if(!function_exists('serviceChargesPercentageOfFamefeet'))
{
    function serviceChagesPercentageOfFamefeet()
    {
        $charges = ServiceCharges::first();
        // $charges_percentage = $charges->service_charges / 100 ;
        return $charges->service_charges;
    }
}

if(!function_exists('celebrityChargesPercentageOfFamefeet'))
{
    function celebrityChagesPercentageOfFamefeet()
    {
        $charges = ServiceCharges::first();
        // $charges_percentage = $charges->service_charges / 100 ;
        return 100 - $charges->service_charges ;
    }
}

if(!function_exists('checkQuantityAndItemAvailableOrNot')){
    function checkQuantityAndItemAvailableOrNot($request)
    {   $shopItem = [];
        $notAvailable = [];
        $shopNotAvailable =false;
         foreach ($request->shop_items as $item) {
            $shop_id = $item['shop_item_id'];
            $shop = Shop::find($shop_id);
            if(!is_null($shop)){
                $shopItem[] =[
                    'shop_item_id' => $shop->id,
                    'price' => $shop->price,
                  ];
               if($shop->quantity < $item['quantity']){
                 $notAvailable[] = [
                  'message' => $shop->title . ' quantity available ' .$shop->quantity,
                 ];
               }
            }else{
               $shopNotAvailable = true;
            }
         }
         if( count($notAvailable))
         {
            return response()->json([
                $notAvailable,
                'shop_item'=> $shopItem,
            ],400);
         }elseif($shopNotAvailable == true){
              return response()->json([
               'message' => 'Item is not Available into Shop',
              ],400);
         }else{
            return response()->json([
                 'available' => true,
                 'shop_item' => $shopItem,
            ],200);
         }
    }

    if (!function_exists('getLogTypeName'))
    {
        function getLogTypeName($log_type) {
            foreach (config('famefeet.log_types') as $key => $value) {
                if($value['id'] == $log_type){
                    return $value['name'];
                }
            }
            return null;
        }
    }

    if(!function_exists('referralBonusOfFamefeet'))
    {
        function referralBonusOfFamefeet($coins)
        {
            $charges_percentage = config('famefeet.referral_bonus_percentage');
            $charges = $charges_percentage / 100 ;
            return $charges * $coins;
        }
    }

    if(!function_exists('getReferredUser'))
    {
        function getReferredUser($user_id)
        {
            $refferUser = ReferUser::where('is_expired',false)
                                    ->where('expire_date','>=', Carbon::now()->toDateTimeString())
                                    ->where('user_id',$user_id)->first();
            return $refferUser;
        }
    }




    if(!function_exists('getUserIdByUsername'))
    {
        function getUserIdByUsername($username)
        {
            $user = User::withTrashed()->where('username',$username)->first();
            if(isset($user)){
                return $user->id;
            }
            return  null;
        }
    }

    if(!function_exists('createSlug'))
    {
        function createSlug($name,$id)
        {
            $slug = preg_replace('/\s+/', '-', $name);
            if(isset($slug)){
                return $slug . '-' . $id;
            }
            return  null;
        }
    }

    if(!function_exists('getUserByUserId'))
    {
        function getUserByUserId($id)
        {
            $user = User::find($id);
            if(isset($user)){
                return $user;
            }
            return  null;
        }
    }

    if(!function_exists('convetCommaDelimitedStrToArray'))
    {
        function convetCommaDelimitedStrToArray($str)
        {
            $arr = explode(',', $str);
            if(isset($arr)){
                return $arr;
            }
            return  null;
        }
    }

}

if(!function_exists('getcheckCelebrityNotificationType'))
{
    function getcheckCelebrityNotificationType($celeb_id){
        $notifications = ['database'];
        $notification_type = Celebrity::where('user_id', $celeb_id->id)->pluck('notification_type')->first();
        if(isset($notification_type)){
            if($notification_type == 0){
                $notifications = ['database', 'mail'];
            }
            elseif ($notification_type == 1){
                $notifications = ['database', 'vonage'];
            }
            elseif($notification_type == 2){
                $notifications = ['database', 'vonage', 'mail'];
            }
        }
        return $notifications;
    }
}

if(!function_exists('getUserNotificationChannelPreferences'))
{
    function getUserNotificationChannelPreferences($user)
    {
        $notifications = ['database'];
        $notification_type = null;
        \Log::info($user);

        $user = getUserByUserId($user->id);
        // \Log::info($user->id);
        // \Log::info($user_id);

        if(isset($user)){
            if($user->user_type == config('famefeet.user_type.celebrity')){
                $notification_type = $user->celebrity->notification_type;
            }
            if($user->user_type == config('famefeet.user_type.fan')){
                $notification_type = $user->fan->notification_type;
            }
            if($user->user_type == config('famefeet.user_type.admin')){
                $notification_type = $user->fan->notification_type;
            }
        }
        if(isset($notification_type)){
            if($notification_type == 0){
                $notifications = ['database', 'mail'];
            }
            elseif ($notification_type == 1){
                $notifications = ['database', 'vonage'];
            }
            elseif($notification_type == 2){
                $notifications = ['database', 'vonage', 'mail'];
            }
        }
        return $notifications;
    }
}

if (!function_exists('checkUserAccountStatus'))
{
    function checkUserAccountStatus($userId) {
        $user = User::withTrashed()->where('id', $userId)->first();

        if($user->deleted_at == null)
        {
            // if ($user->account_status == config('famefeet.account_status.suspend'))
            // {
            //     return 'suspended';
            // }
            // if ($user->account_status == config('famefeet.account_status.block'))
            // {
            //     return 'blocked';
            // }
            return false;
        }
        return true;
    }
}


if (!function_exists('getUserAccountResponse'))
{
    function getUserAccountResponse() {
        return response()->json([
            'message' => "User account has been deleted. You can't perform this action.",
        ], 555);
    }
}
