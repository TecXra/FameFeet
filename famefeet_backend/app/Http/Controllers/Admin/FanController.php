<?php

namespace App\Http\Controllers\Admin;

use App\Events\ChangeOrderStatusEvent;
use App\Http\Controllers\Controller;
use App\Models\BannedUser;
use App\Models\Celebrity;
use App\Models\CelebritySendOffer;
use App\Models\CoinLog;
use App\Models\Fan;
use App\Models\Followship;
use App\Models\Offer;
use App\Models\OrderContent;
use App\Models\Post;
use App\Models\ReportedUser;
use App\Models\SubOrder;
use App\Models\SubscribeUser;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Services\WalletService;

class FanController extends Controller
{
    //get single Fan buy posts
    public function getSingleFanBuyPosts($fanId)
    {
        $fan = Fan::with(['user' => function ($query) {
            $query->withTrashed();
        }])->find($fanId);
        $user = User::withTrashed()->find($fan->user_id);
        $contents = OrderContent::where('user_id',$user->id)->paginate(15);
        return view('fan.post.post')->with('fan',$fan)->with('contents',$contents);
        // $posts = Post::where('celebrity_id',$celebrityId)->paginate(10);
        // return view('celebrity.post.post')->with('posts',$posts)->with('celebrity',$celebrity);
    }

    //show post
    public function showFanBuyContent($contentId){
        $content = OrderContent::find($contentId);
        return view('fan.post.show')->with('content',$content);
    }

    //show post
    public function removeBuyPostContent($contentId){
        $content = OrderContent::find($contentId);
        $content->delete();
        return Redirect::back();
        // return view('fan.post.show')->with('content',$content);
    }

    //get single celebrity offfer
    public function getSingleFanOffersToCelebrity($fanId)
    {
        $fan = Fan::find($fanId);
        $offers = Offer::where('fan_id',$fanId)->paginate(10);
        return view('fan.offer.offer')->with('offers',$offers)->with('fan',$fan);
    }
       //edit single offer
    public function editOffer($offerId){
        $offer = Offer::find($offerId);
        return view('fan.offer.edit')->with('offer',$offer);
    }
    //update offer
    public function updateOffer(Request $request,$offerId){
        $request->validate([
            'title' => 'required|string|max:120',
            'coins' => 'required|numeric',
            'description' => 'required|string'
        ]);
        $offer = Offer::find($offerId);
        $offer->update([
            'title' => $request['title'],
            'price' => $request['price'],
            'description' => $request['description'],
        ]);
        return redirect()->route('single.fan.offers.to.celebrity',$offer->fan_id)
            ->with('success','Offer Update Successfully!');
    }

    // show offer item
    public function showOffer($offerId){
        $offer = Offer::find($offerId);
        return view('fan.offer.show')->with('offer',$offer);
    }


     //get single celebrity offers send To Fan
     public function getSingleFanOffersFromCelebrity($fanId)
     {
         $fan = Fan::find($fanId);
         $celebritySendOffers = CelebritySendOffer::where('fan_id',$fan->id)->paginate(10);
         return view('fan.celebrity_offer.celebrity_offer')
                ->with('celebritySendOffers',$celebritySendOffers)
                ->with('fan',$fan);
     }

        //edit single offer
    public function editFanOfferFromCelebrity($celebrityOfferId){
        $celebritySendOffer = CelebritySendOffer::find($celebrityOfferId);
        return view('fan.celebrity_offer.celebrity_offer_edit')
               ->with('celebritySendOffer',$celebritySendOffer);
    }
    //update offer
    public function updateFanOfferFromCelebrity(Request $request,$celebrityOfferId){
        $request->validate([
            'title' => 'required|string|max:120',
            'price' => 'required|numeric',
            'description' => 'required|string'
        ]);
        $celebritySendOffer = CelebritySendOffer::find($celebrityOfferId);
        $celebritySendOffer->update([
            'title' => $request['title'],
            'price' => $request['price'],
            'description' => $request['description'],
        ]);
        return redirect()->route('single.fan.offers.from.celebrity',$celebritySendOffer->fan_id)
            ->with('success','Offer Update Successfully!');
    }

    // show offer item
    public function showFanOfferFromCelebrity($celebrityOfferId){
        $celebritySendOffer = CelebritySendOffer::find($celebrityOfferId);
        return view('fan.celebrity_offer.celebrity_offer_show')
               ->with('celebritySendOffer',$celebritySendOffer);
    }


     //get Buy Subscription of fan
     public function getFanBuySubscription($fanId){
          $fan = Fan::find($fanId);
          $user = User::find($fan->user_id);
          $subscribeUsers = SubscribeUser::where('user_id',$user->id)->paginate(15);
          return view('fan.subscription.subscribe-user')->with('subscribeUsers',$subscribeUsers)->with('fan',$fan);
     }


        //show all block user from particular Fan
    public function getAllBlockUserOfFan($fanId){
        $fan = Fan::find($fanId);
        $user = $fan->user;
        // return $user;
        $blockUserIds = BannedUser::where('user_id',$user->id)->pluck('banned_user_id');
        $blockUser = User::whereIn('id',$blockUserIds)->paginate(10);
        // $blockUser = $user->blockFrom;
        return view('fan.blockuser.block-user')
        ->with('blockUsers',$blockUser)
        ->with('fan',$fan);
    }

    // Un Block the blocked user from a celebrity
    public function unblockUser($blockUserId){
         $blockUser = BannedUser::where('banned_user_id',$blockUserId)->first();
         $blockUser->delete();
         return Redirect::back();
    }

        //show all block user from particular celebrity
        public function getAllReportUserOfFan($fanId){
            $fan = Fan::find($fanId);
            $user = $fan->user;
            // return $user;
            $reportedUserIds = ReportedUser::where('user_id',$user->id)->pluck('reported_user_id');
            $reports = ReportedUser::where('user_id',$user->id)->paginate(10);
            // return $reports[0]->reported;
            // $reportedUser = User::whereIn('id',$reportedUserIds)->paginate(10);
            // return $reportedUser;
            // $blockUser = $user->blockFrom;
            return view('fan.blockuser.report-user')
            // ->with('reportedUsers',$reportedUser)
            ->with('reports',$reports)
            ->with('fan',$fan);
        }
        // Un Block the blocked user from a celebrity
        public function removeReportUser($repotedUserId){
             $reportedUser = ReportedUser::where('reported_user_id',$repotedUserId)->first();
            //  return $reportedUser;
             $reportedUser->delete();
             return Redirect::back();
        }

        //get All follower
        public function gatAllFollowersOfFan($fanId)
        {
            $fan = Fan::find($fanId);
            $user = User::find($fan->user_id);
            $followers = $user->followers()->paginate(10);
            return view('fan.followers.followers')
                   ->with('followers',$followers)
                   ->with('fan',$fan);
            // return $celebrity;
        }

         // Remove the Follower user Of a celebrity
         public function removeFollowerUser($followerId){

            $follower = Followship::where('follower_id',$followerId)->first();
            $follower->delete();
            return Redirect::back();
       }

        //get All follower
        public function gatAllFollowingsOfFan($fanId)
        {
            $fan = Fan::find($fanId);
            $user = User::find($fan->user_id);
            $followings = $user->following()->paginate(10);
            return view('fan.followers.following')
                   ->with('followings',$followings)
                   ->with('fan',$fan);
            // return $celebrity;
        }

         // un Follow user
        public function unFollowUser($followingId){

            $following = Followship::where('following_id',$followingId)->first();
            $following->delete();
            return Redirect::back();
        }

        /////
        //get All orders
        public function gatAllOrdersOfFan($fanId)
        {
            $fan = Fan::find($fanId);
            $user = User::find($fan->user_id);
            $subOrders = SubOrder::where('user_id',$user->id)->paginate(10);
            return view('fan.orders.orders')
                ->with('subOrders',$subOrders)
                ->with('fan',$fan);
            // return $celebrity;
        }

        // complete order of celebrity
        public function completeOrderOfFan($subOrderId)
        {
            $subOrder = SubOrder::find($subOrderId);
            // return $subOrder;
            $celebrity = Celebrity::find($subOrder->celebrity_id);
            $notifyUser = User::find($celebrity->user_id);
            $user = Auth::user();
            $celebrityWallet = Wallet::where('user_id',$notifyUser->id)->first();
            if($subOrder->status == 'deliver'){
                    $subOrder->status = 'complete';
                    $subOrder->save();

                    // $service_charges = serviceChagesOfFamefeet($subOrder->total_price);
                    $shopItemsCoins = $subOrder->total_price - $subOrder->shipping_charges;

                    $celebrityWallet->available_coins = $celebrityWallet->available_coins + $subOrder->celebrity_charges_price + $subOrder->shipping_charges;
                    $celebrityWallet->total_coins = $celebrityWallet->total_coins + $subOrder->celebrity_charges_price + $subOrder->shipping_charges;
                    $celebrityWallet->save();

                    //Referred user charges
                    $referredUser = getReferredUser($notifyUser->id);
                    if(isset($referredUser)){
                        WalletService::referralBonusOfFamefeet(config('famefeet.log_type.referral_bonus'),$shopItemsCoins,$referredUser);
                    }
                    // WalletService::buySellLog(config(config('famefeet.log_type_buy'),$coinsTransferToCelebrity,$celebrityWallet->id,$service_charges);

                    event(new ChangeOrderStatusEvent($subOrder,$user,$notifyUser));
                    return Redirect::back()->with('success','Order complete successfully!');
            }else{
                return Redirect::back()->with('error','Check the order status!');
            }
        }

        //order Details
        public function orderDetailsOfFan($subOrderId)
        {
            $subOrder = SubOrder::find($subOrderId);
            return view('celebrity.orders.show')
                ->with('subOrder',$subOrder);
        }




        ///////
        public function transectionLogsOfFan($fanId){
            $fan = Fan::find($fanId);
            $user = User::find($fan->user_id);
            $logs = CoinLog::where('sender_user_id',$user->id)
                             ->orWhere('receiver_user_id',$user->id)
                             ->orderBy('id','DESC')->paginate(15);
            // return $logs;
            return view('fan.transection_log.logs')->with('fan',$fan)->with('logs',$logs);
        }
}
