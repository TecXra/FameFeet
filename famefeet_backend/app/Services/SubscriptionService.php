<?php

namespace Services;

use App\Events\BuySubscriptionEvent;
use App\Events\BuySubscriptionFanEvent;
use App\Events\UpdateSubscriptionPriceEvent;
use App\Models\BannedUser;
use App\Models\Celebrity;
use App\Models\Hide;
use App\Models\Post;
use App\Models\SubscribeUser;
use App\Models\SubscribeUserHistory;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Wallet;
use App\Notifications\SendWarningMailToAutoSubcribeNotification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class SubscriptionService{
    public static function newSubcription($request){
        try {
            $celebrity_id = Auth::user()->celebrity->id;
            $subs = Subscription::where('celebrity_id',$celebrity_id)->get();
            if(count($subs) == 0){
               $subscription = new Subscription();
               $subscription->coins = $request->coins;
               $subscription->celebrity_id = $celebrity_id;
               $subscription->save();
               return response()->json([
                   'message' => "Subscription plan created successfully!"
               ]);
            }else{
               return response()->json([
                   'message' => "Subscription already exist!"
               ],401);
            }

         } catch (\Exception) {
           return response()->json([
               'message' => 'Something Wrong!',
           ],404);
         }
    }
   

    public static function renewSubscription(){
        $subscribeUsers = SubscribeUser::where('subscription_end_date', '<=', Carbon::now()->toDateTimeString())->get();

        foreach ($subscribeUsers as $subscribeUser) {
            if($subscribeUser->status == false){
                SubscriptionService::saveSubUserHistory($subscribeUser);
                $subscribeUser->delete();
                return response()->json([
                    'message' => 'User un-subscribe successfully!',
                ]);
            }elseif($subscribeUser->status == true){

                $subscription = Subscription::find($subscribeUser->subscription_id);

                $celebrity = Celebrity::where('id', $subscription->celebrity_id)->first();
                $celebUser= User::withTrashed()->find($celebrity->user_id);
                $fanUser= User::withTrashed()->find($subscribeUser->user_id);
                
                if ($celebUser->account_status == config('famefeet.account_status.deleted') ||
                $fanUser->account_status == config('famefeet.account_status.deleted')) {

                // Update the status to 0 and save
                // $subscribeUser->status = false;
                $subscribeUser->delete();
                // $subscribeUser->save();

                return response()->json([
                    'message' => 'Account was deleted. Subscription status updated.',
                ]);
            }

                // if($celebUser->account_status != config('famefeet.account_status.deleted') &&
                // $fanUser->account_status != config('famefeet.account_status.deleted')){

                if($subscription->status == true){
                    $userWallet = Wallet::where('user_id',$subscribeUser->user_id)->first();
                    SubscriptionService::saveSubUserHistory($subscribeUser);
                    if($userWallet->available_coins >= $subscription->coins){
                        SubscriptionService::updateSubscribeUserSubscription($subscription,$subscribeUser);
                        SubscriptionService::dispatchSubscribeUserSubscription($subscription,$subscribeUser,$userWallet,config('famefeet.log_type.renew_subscription'));
                        return response()->json([
                            'message' => 'User subscribed successfully.!',
                        ]);
                    }else{
                        SubscriptionService::saveSubUserHistory($subscribeUser);
                        $subscribeUser->delete();
                        return response()->json([
                            'message' => 'User un-subscribed successfully!',
                        ]);
                    }
                }else{
                    SubscriptionService::saveSubUserHistory($subscribeUser);
                    $subscribeUser->delete();
                    return response()->json([
                        'message' => 'User un-subscribed successfully!',
                    ]);
                }


            //  }else{
            //     return response()->json([
            //         'message' => 'account was deleted',
            //       ]);
            //     }



            }
        }

    }


    public static function saveSubUserHistory($subscribeUserObj){
        $subUserHistory = new SubscribeUserHistory();
        $subUserHistory->create([
            'coins' => $subscribeUserObj->coins,
            'active' => $subscribeUserObj->status,
            'subscription_start_date' =>$subscribeUserObj->subscription_start_date,
            'subscription_end_date'=> $subscribeUserObj->subscription_end_date,
            'subscription_id' => $subscribeUserObj->subscription_id,
            'user_id' => $subscribeUserObj->user_id,
        ]);
    }

    public static function updateSubscribeUserSubscription($subscription,$subscribeUser){
        $subscribeUser->update([
            'coins' => $subscription->coins,
            'subscription_start_date' => Carbon::now(),
            'subscription_end_date' => Carbon::now()->addMonth(),
            // 'subscription_end_date' => Carbon::now()->addMinutes(2),

        ]);
    }

    public static function dispatchSubscribeUserSubscription($subscription,$subscribeUser,$userWallet,$logType){
        $celebrity = Celebrity::find($subscription->celebrity_id);
        $celebrity_user_id = $celebrity->user->id;
        $notifyUser = $celebrity->user;
        $user = User::find($subscribeUser->user_id);
        $celebrityWallet = Wallet::where('user_id',$celebrity_user_id)->first();

        $referral_table_name =  'subscribe_users';
        $referral_table_id = $subscribeUser->id;
        //Helper function
        $service_charges = serviceChagesOfFamefeet($subscription->coins);
        $coinsTransferToCelebrity = $subscription->coins - $service_charges;

        $userWallet->update([
            "total_coins" => $userWallet->total_coins - $subscription->coins,
            "available_coins" => $userWallet->available_coins - $subscription->coins,
        ]);

        $celebrityWallet->update([
            "total_coins" => $celebrityWallet->total_coins + $coinsTransferToCelebrity,
            "available_coins" => $celebrityWallet->available_coins + $coinsTransferToCelebrity,
        ]);

        //Transection History
        WalletService::buySellLog($logType,$subscription->coins,$userWallet,$celebrityWallet,$service_charges,$referral_table_name,$referral_table_id);
        //Referred user charges
        $referredUser = getReferredUser($notifyUser->id);
        if(isset($referredUser)){
            WalletService::referralBonusOfFamefeet(config('famefeet.log_type.referral_bonus'),$subscription->coins,$referredUser);
        }
         event(new BuySubscriptionEvent($subscribeUser,$notifyUser,$user));
         event(new BuySubscriptionFanEvent($subscribeUser,$notifyUser,$user));

    }

    public static function edit($request,$id){
        $subscription = Subscription::find($id);
        $celebrity =  Celebrity::find($subscription->celebrity_id);
        $user = User::find($celebrity->user_id);
        // return $user;
        $subscription->update([
            'coins' => $request->coins,
        ]);

        $subscribeUsers = SubscribeUser::where('subscription_id',$subscription->id)->get();
       
        if(count($subscribeUsers) > 0){
            foreach ($subscribeUsers as $subscUser) {
                $notifyUser = User::find($subscUser->user_id);
                if($notifyUser){
                event(new UpdateSubscriptionPriceEvent($subscription,$notifyUser,$user));
            }
            }
        }
        // return $data;

        return response()->json([
            'message' => 'Subscription updated successfully!'
        ]);

    }

    public static function buy($id){
        
        
        

        try {
            $user = Auth::user();
            $subUser = SubscribeUser::where('user_id',$user->id)
                        ->where('subscription_id',$id)->get();
            // return $subUser;
            $subscription = Subscription::find($id);
            $celebrity_user = Celebrity::where('id',$subscription->celebrity_id)->first();
            if(checkUserAccountStatus($celebrity_user->user_id))
            {
                return getUserAccountResponse();
            }
            $del_user=User::where('account_status',4)->where('id', $celebrity_user->user_id)->first();
            if(!$del_user){
            // return $subscription;
            if($subscription->status == true){
                $celebrity = Celebrity::find($subscription->celebrity_id);
                $celebrity_user_id = $celebrity->user->id;
                $celebrityWallet = Wallet::where('user_id',$celebrity_user_id)->first();
                $userWallet = Wallet::where('user_id',$user->id)->first();
                if(is_null($celebrityWallet) == null && is_null($userWallet) == null){
                    if(count($subUser) == 0){
                        // return $userWallet[0]['available_coins'];
                        if($userWallet->available_coins >= $subscription->coins){
                           $subscribeUser = SubscriptionService::saveSubscribeUser($subscription,$user);
                            SubscriptionService::dispatchSubscribeUserSubscription($subscription,$subscribeUser,$userWallet,config('famefeet.log_type.subscription_text'));
                            return response()->json([
                                'message' => 'Subscribed Successfully!',
                            ]);
                        }else{
                            return response()->json([
                                'message' => 'Insuficient Balance!',
                            ],401);
                        }

                    }else{
                    return response()->json([
                        'message' => 'You Already Have This Subscription!',
                    ],400);
                    }
                }else{
                    return response()->json([
                        'message' => 'Please Check Wallet First',
                    ],400);
                }
            }else{
                return response()->json([
                    'message' => 'This Subscription is not Available',
                ],400);
            }
        }else{
            return response()->json([
                'message' => "Your account has been deleted. You can't perform this action."

            ]);
        }
            // return $subscription;

        } catch (\Throwable) {
            return response()->json([
                'message' => 'Something Wrong!',
            ],400);
        }
    }

    public static function saveSubscribeUser($subscription,$user){
        $subscribeUser = New SubscribeUser();
        $subscribeUser->coins = $subscription->coins;
        $subscribeUser->subscription_start_date = Carbon::now()->toDateTimeString();
        $subscribeUser->subscription_end_date = Carbon::now()->addMonth()->toDateTimeString();
        // $subscribeUser->subscription_end_date = Carbon::now()->addMinutes(2)->toDateTimeString();

        $subscribeUser->user_id = $user->id;
        $subscribeUser->subscription_id = $subscription->id;
        $subscribeUser->save();
        return $subscribeUser;
    }

    public static function subscribedCelebrityPosts($request,$authUser){
            // $user = Auth::user();
            $query = [];
            $data = [];
            $hide_ids = Hide::where('user_id',$authUser->id)->pluck('post_id');
            $blockedUserIds = BannedUser::where('user_id',$authUser->id)->pluck('banned_user_id');
            $block_celebrity_ids = Celebrity::whereIn('user_id',$blockedUserIds)->pluck('id')->toArray();
            $subscription_ids = SubscribeUser::where('user_id',$authUser->id)->pluck('subscription_id');
            $subscribe_celebrity_ids = Subscription::whereIn('id',$subscription_ids)->pluck('celebrity_id')->toArray();
            $diffCelebrity  = array_diff($subscribe_celebrity_ids,$block_celebrity_ids);

            if(count($diffCelebrity) != 0){
                $query = Post::query();
                $query = $query->whereHas('celebrity.user', function ($query){
                    $query->where('account_status',config('famefeet.account_status.active'));
                });
                if($request->filled('search')){
                    $query->where('title', 'like', '%'.$request->search.'%');
                }
                $query =  $query->with(['media' => function ($query) {
                    $query->select('id','file_path','mediaable_id');
                }])
                ->with('categories:id,text')
                ->with(['celebrity'=> function($query){
                $query->select('id','user_id')
                ->with('user:id,username,avatar')
                ->get();
                }])->with(['comments' => function ($query) {
                    $query->select('id', 'comment','post_id','user_id','created_at')
                    ->with('user:id,username,avatar')
                    ->get();
                }])
                ->withCount('likes')
                ->whereNotIn('id',$hide_ids)
                ->whereIn('celebrity_id',$diffCelebrity)
                ->orderBy('created_at','DESC')
                ->get();

                if(count($query) != 0){
                    foreach ($query as $q) {
                        $q->lock_media = 0;
                        $data[] = $q;
                }
                return $data;
            }
            return $query;
        }
    }

    public static function authUserBuySubscription($user){
        $blockedUserIds = BanUserService::getBlockUser($user);
        $subscriptionIds = SubscribeUser::where('user_id',auth()->user()->id)->pluck('subscription_id');
        $subscribeCelebrityIds = Subscription::whereIn('id',$subscriptionIds)->withTrashed()->pluck('celebrity_id');
        $subscribeUserIds = Celebrity::whereIn('id',$subscribeCelebrityIds)->pluck('user_id')->toArray();

        $UserIds = array_diff($subscribeUserIds,$blockedUserIds);
        $celebrities = User::query()
                ->select('id', 'username', 'avatar', 'date_of_birth', 'user_type','account_status')
                ->with(['celebrity' => function($query) use ($user){
                    $query->select('id', 'user_id')->with(['subscription' => function($query) use ($user) {
                        $query->select('id', 'celebrity_id')->with(['subscribeUser' => function ($query) use ($user){
                            $query->where('user_id', $user->id);
                        }]);
                    }]);
                }])
                ->withTrashed()
                ->where('user_type', '=', config('famefeet.user_type.celebrity'))
                ->where('id', '!=', $user->id)
                ->whereIn('id', $UserIds)
                // ->whereNot('account_status',4)
                ->get();

        if(count($celebrities) > 0){
            foreach ($celebrities as $cel) {
                $result[] = [
                    'id' => $cel->id,
                    'username' => $cel->username,
                    'avatar' => $cel->avatar,
                    "avatarURL" => $cel->avatarURL,
                    'user_type' => $cel->user_type,
                    'account_status'=> $cel->account_status,
                    'user_type_name' => $cel->user_type_name,
                    'subscription' => $cel->celebrity->subscription
                ];
         }
         return $result;
        }else{
            return $celebrities;
        }

    }


    public static function sendMailToAutoSubscribe(){
        $subscribeUsers = SubscribeUser::where('status',true)->get();
        $today = Carbon::now();

        foreach ($subscribeUsers as $subscribeUser) {
            $updated_date = Carbon::parse($subscribeUser->subscription_end_date)->subDay(config('famefeet.before_auto_subscribe_days'))->toDateString();

            if($updated_date == $today->toDateString())
            {
                $subscription = Subscription::find($subscribeUser->subscription_id);
                $celebrity = Celebrity::find($subscription->celebrity_id);
                $user = User::find($celebrity->user_id);
                $notifyUser = User::find($subscribeUser->user_id);
                Notification::send($notifyUser,new SendWarningMailToAutoSubcribeNotification($user,$subscription));
            }
        }
        return true;
    }
}
