<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationHelper;
use App\Models\SubscribeUser;
use App\Models\Celebrity;
use App\Models\User;
use App\Events\EnableDisableSubcription;
use App\Events\CelebEnableSubcription;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Services\SubscriptionService;

class SubscriptionController extends Controller
{
    //
    public function createSubscription(Request $request){
        $validator = Validator::make($request->all(), [
        'coins' => 'required|numeric|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $result = SubscriptionService::newSubcription($request);
        return $result;
   }


    public function buySubscription($subscription_id){
        $result = SubscriptionService::buy($subscription_id);
        return $result;
    }


    public function editSubscription(Request $request,$subscription_id){
        $validator = Validator::make($request->all(), [
            'coins' => 'required|numeric|min:1'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
        $result = SubscriptionService::edit($request,$subscription_id);
        return $result;
    }

    public function changeStatusOfSubscriptionCelebritySide($subscription_id,Request $request){
        $sender = Auth::user(); 
        
           $subscription = Subscription::where('celebrity_id',auth()->user()->celebrity->id)
                           ->find($subscription_id);

           $result = SubscribeUser::where('subscription_id', $subscription->id )->where('status',1)->get();
           
           $userIds = $result->pluck('user_id')->toArray();
    
           $receivers = User::whereIn('id', $userIds)->get();
       
        
           
            $validator = Validator::make($request->all(),[
                'status' => 'required'
            ]);

            if($validator->fails()){
                return response()->json($validator->errors(),400);
            }
            if($request->status == 1){
            $subscription->status = $request->status;
            $subscription->save();


            foreach ($receivers as $receiver) {
                event(new CelebEnableSubcription($sender, $receiver));
                
            }
           return response()->json([
                'message' => 'Subscription stauts updated successfully!'
           ]);
        }else{
            $subscription->status = $request->status;
            $subscription->save();

            return response()->json([
                'message' => 'Subscription stauts updated successfully!'
           ]);
        }
    }
    
    public function autoSubscribe(){
        $result = SubscriptionService::renewSubscription();
        return $result;
    }

    public function  getSubcriptionOnCelebritySide(){
        try {
        //     $subscriptions = Subscription::query()
        //         ->with(['subscribeUser' => function ($query) {
        //          $query->select('id', 'coins', 'status', 'subscription_start_date', 'subscription_end_date', 'subscription_id', 'user_id')
        //     ->whereHas('user', function ($userQuery) {
        //         $userQuery->whereNull('deleted_at');
        //     });
        //  }])
        // ->where('celebrity_id', auth()->user()->celebrity->id)
        //  ->get();

        //    foreach ($subscriptions as $subscription) {
        //      $subscribeUsers = $subscription->subscribeUser;
        //        foreach ($subscribeUsers as $subscribeUser) {
        //           $user = $subscribeUser->user;
        //          $subscribeUser['user'] = $user;
        //       }
        //     }
            $subscriptions = Subscription::query()
            ->with(['subscribeUser' => function ($query) {
                $query->select('id', 'coins','status','subscription_start_date','subscription_end_date','subscription_id','user_id')
                // ->with('user:id,username,avatar,user_type')
                ->get();
            }])->where('celebrity_id',auth()->user()->celebrity->id)->get();
            foreach ($subscriptions as $subscription) {
                $subscribeUsers = $subscription->subscribeUser;
                foreach ($subscribeUsers as $subscribeUser) {
                    $user=User::withTrashed()->find($subscribeUser->user_id);
                    $subscribeUser['user'] =$user;

                }
            }



         return $subscriptions;
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Something Wrong!'
            ],404);
        }

    }

    public function getSubscribedCelebrityPosts(Request $request){
    //    return $request;
      $authUser = Auth::user();
      $result = SubscriptionService::subscribedCelebrityPosts($request,$authUser);
      $result = PaginationHelper::paginate($result,$request->perPage);
      return $result;
    //   return $result;
    }


    public function getAuthUserBuySubscriptions(){
        // return Auth::user();
      $user = Auth::user();
      $result = SubscriptionService::authUserBuySubscription($user);
      return $result;
    }

    public function changeSubcribedSubscriptionStatus(Request $request,$subscribeId){
        $sender = Auth::user(); 
         $result = SubscribeUser::where('user_id',Auth::user()->id)->find($subscribeId);
          $subscriptionId = $result->subscription_id;
          $subscription = Subscription::find($subscriptionId);
          $celebrityId = $subscription->celebrity_id;
          $celebrity = Celebrity::find($celebrityId);
          $receiver = User::find($celebrity->user_id);
          if($receiver !== null ){
          if($request->status==1){
             $result->update([
            'status' => $request->status,
         ]);
       
         event(new EnableDisableSubcription($sender,$receiver));
        
         return response()->json([
            'message' => 'Subscription stauts updated successfully!'
         ]);
         
        }else{
            $result->update([
                'status' => $request->status,
             ]);
             return response()->json([
                'message' => 'Subscription stauts updated successfully!'
             ]);
        }
     } else{
            return response()->json([
                // 'message' => 'This account has been deleted!'
                'message' => ["This account has been deleted!"]
            ],401);
        }
    }

    // public function warningMailOfAutoSubscribe(){
    //     $result = SubscriptionService::sendMail();
    //     return $result;
    // }
}
