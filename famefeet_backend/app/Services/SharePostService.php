<?php

namespace Services;

use App\Events\SharePostEvent;
use App\Models\CelebritySendOffer;
use App\Models\OrderContent;
use App\Models\Post;
use App\Models\SharePost;
use App\Models\SubscribeUser;
use App\Models\Subscription;
use App\Models\User;
use App\Models\BannedUser;
use Illuminate\Support\Facades\Auth;

class SharePostService {

    public static function PostShare($request){
        $user = Auth::user();
        $notifyUser = User::find($request->user_id);


        $fan_ban_celeb=BannedUser::where('user_id', $user->id)->where('banned_user_id',$notifyUser->id)->first();
        $celeb_ban_fan=BannedUser::where('user_id',$notifyUser->id)->where('banned_user_id',$user->id)->first();


    if(!$fan_ban_celeb && !$celeb_ban_fan ){
        $alreadyShare = SharePost::where('user_id',$request->user_id)
                ->where('post_id',$request->post_id)->get();
        if(count($alreadyShare) == 0 ){
        $sharePost = New SharePost();
        $sharePost->create($request->all());

        $post = Post::find($request->post_id);

        broadcast(new SharePostEvent($post,$notifyUser,$user));
        return response()->json([
        'message' => 'Offer sent successfully!'
        ]);
        }else{
        return response()->json([
        'message' => 'You Have Already Share This Post!'
        ],400);
        }
    }else{
        return response()->json([
            'message' => 'you can not share content you are blocked!'

        ]);
    }
    }

    public static function getSharePostFanSide(){
        $post_ids = SharePost::where('user_id',Auth::user()->id)->pluck('post_id')->toArray();
        // return $post_ids;
        $buy_post_ids = OrderContent::where('user_id',Auth::user()->id)->pluck('post_id')->toArray();
        // return $buy_post_ids;
        $diff_post_ids = array_diff($post_ids,$buy_post_ids);
        // return $dif_post_ids;
        $sharePost = Post::query()->with(['celebrity'=> function($query){
            $query->select('id','user_id')
            // ->with('user:id,username,date_of_birth,avatar,user_type')
            ->with(['user' => function($query){
                $query->withTrashed()->select('id','username','date_of_birth','avatar','user_type','account_status');
            }])
            ->get();
        }])
            ->with(['media' => function ($query) {
            $query->select('id', 'file_path','mediaable_id');
        }])
        ->whereIn('id',$diff_post_ids)
        ->orderBy('created_at','DESC')
        ->get();


        $user = Auth::user();
        $fan_id = $user->fan->id;
        $celebritySendOffer = CelebritySendOffer::query()
        ->with(['celebrity'=> function($query){
            $query->select('id','user_id')
            // ->with('user:id,username,avatar')
            ->with(['user' => function($query){
                $query->withTrashed()->select('id','username','avatar','account_status');
            }])
            ->get();
         }])->with('media')
        ->where('fan_id',$fan_id)
        ->whereNot('status','buy')
        ->orderBy('created_at','DESC')
        ->get();
        return response()->json([
            'share_posts' => $sharePost,
            'celebrity_send_offers' => $celebritySendOffer
        ]);
    }

    public static function getPostForSharing($id){
        $celebrity_id = Auth::user()->celebrity->id;
        $buy_post_ids = OrderContent::where('user_id',$id)->pluck('post_id');
        $subscription = Subscription::where('celebrity_id',$celebrity_id)->first();
        if(isset($subscription)){
            $subscribeUser = SubscribeUser::where('user_id',$id)
            ->where('subscription_id',$subscription->id)
            ->first();
        }

        if(isset($subscribeUser)){
           return $posts = [];
        }elseif(count($buy_post_ids) > 0){
            $posts = Post::query()
            ->with(['media' => function ($query) {
                   $query->select('id', 'file_path','mediaable_id');
               }])
            ->where('celebrity_id',$celebrity_id)
            ->whereNotIn('id',$buy_post_ids)
            ->get();
            return $posts;
        }else{
            $posts = Post::query()
            ->with(['media' => function ($query) {
                   $query->select('id', 'file_path','mediaable_id');
               }])
            ->where('celebrity_id',$celebrity_id)
            ->get();
            return $posts;
        }

    }

}
