<?php

namespace App\Http\Controllers\Admin;

use App\Events\ChangeOrderStatusEvent;
use App\Http\Controllers\Controller;
use App\Models\BankAccountDetail;
use App\Models\BannedUser;
use App\Models\Category;
use App\Models\Celebrity;
use App\Models\CelebritySendOffer;
use App\Models\CoinLog;
use App\Models\Followship;
use App\Models\Offer;
use App\Models\Post;
use App\Models\Redeem;
use App\Models\ReportedUser;
use App\Models\Shop;
use App\Models\SubOrder;
use App\Models\SubscribeUser;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Services\WalletService;

class CelebrityController extends Controller
{
    //get single celebrity posts
    public function getSingleCelebrityPosts($celebrityId)
    {
        $celebrity = Celebrity::find($celebrityId);
        $posts = Post::where('celebrity_id',$celebrityId)->orderBy('updated_at', 'desc')->paginate(10);
        return view('celebrity.post.post')->with('posts',$posts)->with('celebrity',$celebrity);
    }

    //edit post
    public function editPost($postId)
    {
        $post = Post::find($postId);
        $category = Category::all();
        return view('celebrity.post.edit')
              ->with('categories',$category)
              ->with('post',$post);
    }

    //update posts
    public function updatePost(Request $request,$postId)
    {
      $request->validate([
          'title' => 'required|string|max:120',
          'price' => 'required|numeric',
          'description' => 'required|string'
      ]);
      $post = Post::find($postId);
          $post->update([
              'title' => $request['title'],
              'price' => $request['price'],
              'description' => $request['description'],
          ]);
          $categories_ids = $request->category_id;
          $post->categories()->sync($categories_ids);
          return redirect()->route('single.celebrity.posts',$post->celebrity_id)
                 ->with('success','Post Update Successfully!');
    }
   //show post
    public function showPost($postId){
        $post = Post::find($postId);
        return view('celebrity.post.show')->with('post',$post);
    }

    //get single celebrity posts
    public function getSingleCelebrityShops($celebrityId)
      {
          $celebrity = Celebrity::find($celebrityId);
          $shops = Shop::where('celebrity_id',$celebrityId)->paginate(10);
          return view('celebrity.shop.shop')->with('shops',$shops)->with('celebrity',$celebrity);
    }

    //edit single Shop
    public function editShop($shopId){
        $shop = Shop::find($shopId);
        return view('celebrity.shop.edit')->with('shop',$shop);
    }
    //update shop
    public function updateShop(Request $request,$shopId){
        $request->validate([
            'title' => 'required|string|max:120',
            'price' => 'required|numeric',
            'description' => 'required|string'
        ]);
        $shop = Shop::find($shopId);
        $shop->update([
            'title' => $request['title'],
            'price' => $request['price'],
            'description' => $request['description'],
        ]);
        return redirect()->route('single.celebrity.shops',$shop->celebrity_id)
            ->with('success','Shop Item Update Successfully!');
    }

    // show shop item
    public function showShop($shopId){
        $shop = Shop::find($shopId);
        return view('celebrity.shop.show')->with('shop',$shop);
    }

     //get single celebrity offfer
     public function getSingleCelebrityOffers($celebrityId)
     {
         $celebrity = Celebrity::find($celebrityId);
         $offers = Offer::where('celebrity_id',$celebrityId)->paginate(10);
         return view('celebrity.offer.offer')->with('offers',$offers)->with('celebrity',$celebrity);
     }

   //edit single offer
   public function editOffer($offerId){
       $offer = Offer::find($offerId);
       return view('celebrity.offer.edit')->with('offer',$offer);
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
       return redirect()->route('single.celebrity.offers',$offer->celebrity_id)
           ->with('success','Offer Update Successfully!');
   }

   // show offer item
   public function showOffer($offerId){
       $offer = Offer::find($offerId);
       return view('celebrity.offer.show')->with('offer',$offer);
   }

    //get single celebrity offers send To Fan
    public function getSingleCelebrityOffersToFan($celebrityId)
        {
            $celebrity = Celebrity::find($celebrityId);
            $celebritySendOffers = CelebritySendOffer::where('celebrity_id',$celebrityId)->paginate(10);
            return view('celebrity.celebrity_offer.celebrity_offer')
                   ->with('celebritySendOffers',$celebritySendOffers)
                   ->with('celebrity',$celebrity);
        }

    //edit single offer
    public function editCelebrityOfferToFan($celebrityOfferId){
        $celebritySendOffer = CelebritySendOffer::find($celebrityOfferId);
        return view('celebrity.celebrity_offer.celebrity_offer_edit')
               ->with('celebritySendOffer',$celebritySendOffer);
    }
    //update offer
    public function updateCelebrityOfferToFan(Request $request,$celebrityOfferId){
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
        return redirect()->route('single.celebrity.offers.to.fan',$celebritySendOffer->celebrity_id)
            ->with('success','Offer Update Successfully!');
    }

    // show offer item
    public function showCelebrityOfferToFan($celebrityOfferId){
        $celebritySendOffer = CelebritySendOffer::find($celebrityOfferId);
        return view('celebrity.celebrity_offer.celebrity_offer_show')
               ->with('celebritySendOffer',$celebritySendOffer);
    }




   // get all subscribe user of single celebrity
   public function getAllSubscribeUserOfCelebrity($celebrityId){
          $celebrity = Celebrity::find($celebrityId);
          $subscriptions = Subscription::withTrashed()->where('celebrity_id',$celebrity->id)->paginate(10);
        //   $subscriprions =  $celebrity->withTrashed()->subscription;
        //   return $subscriprions;
          return view('celebrity.subscription.subscribe-user')
                ->with('subscriptions',$subscriptions)
                ->with('celebrity',$celebrity);
   }

   // subscribe user chage status
   public function changeStatusOfSubscribeUser($subscribeId){
       $subscribeUser = SubscribeUser::where('id','=',$subscribeId)->first();
        if($subscribeUser->status == true){
                $subscribeUser->update([
                   'status' => false
                ]);
        }else{
            $subscribeUser->update([
                'status' => true
             ]);
        }
        // $subscribeUser->status = $status;
        return Redirect::back();
   }

      // get all subscription of single celebrity
      public function getAllSubscriptionsOfCelebrity($celebrityId){
        $celebrity = Celebrity::find($celebrityId);
        $subscriptions = Subscription::withTrashed()->where('celebrity_id',$celebrity->id)->paginate(10);
      //   $subscriprions =  $celebrity->withTrashed()->subscription;
      //   return $subscriprions;
        return view('celebrity.subscription.subscriptions')
              ->with('subscriptions',$subscriptions)
              ->with('celebrity',$celebrity);
    }


       // subscribe user chage status
    public function changeStatusOfSubscription($subscriptionId){
        $subscription = Subscription::find($subscriptionId);
        // return $subscription;
        if($subscription->status == true){
                $subscription->status = 0;
                $subscription->save();
        }else{
            $subscription->status = 1;
            $subscription->save();
        }
        //  return $subscription->status;
        return Redirect::back();
    }

    //show all block user from particular celebrity
    public function getAllBlockUserOfCelebrity($celebrityId){
        $celebrity = Celebrity::find($celebrityId);
        $user = $celebrity->user;
        // return $user;
        $blockUserIds = BannedUser::where('user_id',$user->id)->pluck('banned_user_id');
        $blockUser = User::whereIn('id',$blockUserIds)->paginate(10);
        // $blockUser = $user->blockFrom;
        return view('celebrity.blockuser.block-user')
        ->with('blockUsers',$blockUser)
        ->with('celebrity',$celebrity);
    }
    // Un Block the blocked user from a celebrity
    public function unblockUser($blockUserId){
         $blockUser = BannedUser::where('banned_user_id',$blockUserId)->first();
         $blockUser->delete();
         return Redirect::back();
    }

        //show all block user from particular celebrity
        public function getAllReportUserOfCelebrity($celebrityId){
            $celebrity = Celebrity::find($celebrityId);
            $user = $celebrity->user;
            // $reportedUserIds = ReportedUser::where('user_id',$user->id)->pluck('reported_user_id');
            $reports = ReportedUser::where('user_id',$user->id)->paginate(10);

            return view('celebrity.blockuser.report-user')
            // ->with('reportedUsers',$reportedUser)
            ->with('reports',$reports)
            ->with('celebrity',$celebrity);
        }
        // Un Block the blocked user from a celebrity
        public function removeReportUser($repotedUserId){
             $reportedUser = ReportedUser::where('reported_user_id',$repotedUserId)->first();
            //  return $reportedUser;
             $reportedUser->delete();
             return Redirect::back();
        }

        //get All follower
        public function gatAllFollowersOfCelebrity($celebrityId)
        {
            $celebrity = Celebrity::find($celebrityId);
            $user = User::withTrashed()->find($celebrity->user_id);
            $followers = $user->followers()->paginate(10);
            return view('celebrity.followers.followers')
                   ->with('followers',$followers)
                   ->with('celebrity',$celebrity);
            // return $celebrity;
        }

         // Remove the Follower user Of a celebrity
         public function removeFollowerUser($followerId){

            $follower = Followship::where('follower_id',$followerId)->first();
            $follower->delete();
            return Redirect::back();
       }

        //get All follower
        public function gatAllFollowingsOfCelebrity($celebrityId)
        {
            $celebrity = Celebrity::find($celebrityId);
            $user = User::withTrashed()->find($celebrity->user_id);
            $followings = $user->following()->paginate(10);
            return view('celebrity.followers.following')
                   ->with('followings',$followings)
                   ->with('celebrity',$celebrity);
            // return $celebrity;
        }

         // un Follow user
         public function unFollowUser($followingId){

            $following = Followship::where('following_id',$followingId)->first();
            $following->delete();
            return Redirect::back();
       }

        //get All orders
        public function gatAllOrdersOfCelebrity($celebrityId)
        {
            $celebrity = Celebrity::find($celebrityId);
            $user = User::find($celebrity->user_id);
            $subOrders = SubOrder::where('celebrity_id',$celebrityId)->paginate(10);
            return view('celebrity.orders.orders')
                   ->with('subOrders',$subOrders)
                   ->with('celebrity',$celebrity);
            // return $celebrity;
        }

         // complete order of celebrity
        public function completeOrderOfCelebrity($subOrderId)
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
        public function orderDetailsOfCelebrity($subOrderId)
        {
            $subOrder = SubOrder::find($subOrderId);
            return view('celebrity.orders.show')
                   ->with('subOrder',$subOrder);
        }

        //All redeem requests from the celebrity
        public function gatAllRedeemRequests($celebrityId){
            $celebrity = Celebrity::find($celebrityId);
            $user = User::withTrashed()->find($celebrity->user_id);
            $data = Redeem::where('user_id',$user->id)->paginate(10);
            return view('celebrity.redeem.redeems')
            ->with('celebrity',$celebrity)
            ->with('redeems',$data);
        }

        //All Transection logs of Celebrity
        public function transectionLogsOfCelebrity($celebrityId){
            $celebrity = Celebrity::find($celebrityId);
            $user = User::withTrashed()->find($celebrity->user_id);
            $logs = CoinLog::where('sender_user_id',$user->id)
                             ->orWhere('receiver_user_id',$user->id)
                             ->orderBy('id','DESC')->paginate(15);
            return view('celebrity.transection_log.logs')->with('celebrity',$celebrity)->with('logs',$logs);
        }

         //All Bank Account of celebrity
        public function getAllCelebrityBankAccountsDetails($celebrityId){
            $celebrity = Celebrity::find($celebrityId);
            $user = User::withTrashed()->find($celebrity->user_id);
            $data = BankAccountDetail::where('user_id',$user->id)->paginate(10);
            return view('celebrity.user_account.index')
                   ->with('celebrity',$celebrity)
                   ->with('accounts',$data);
        }

        //edit user Bank Account
        public function editCelebrityBankAccount($accountId){
            $account = BankAccountDetail::find($accountId);
            return view('celebrity.user_account.edit')->with('account',$account);
        }

        //update user Bank Account
         public function updateCelebrityBankAccount(Request $request,$accountId){
            $request->validate([
                'account_type' => 'required|string',
                'routing_number' => 'required|numeric',
                'account_number' => 'required|numeric',
                'name_on_account' => 'required|string',
                'bank_name' => 'required|string',
            ]);
            $account = BankAccountDetail::find($accountId);
            $account->account_type = $request->account_type;
            $account->routing_number = $request->routing_number;
            $account->account_number = $request->account_number;
            $account->name_on_account = $request->name_on_account;
            $account->bank_name = $request->bank_name;
            $account->save();
            return redirect()->route('celebrity.bank.accounts',$account->user->celebrity->id)
            ->with('success','Account details update successfully!');
        }

         //delete user Bank Account
          public function deleteCelebrityBankAccount($accountId){
            $account = BankAccountDetail::find($accountId);
            $account->delete();
            return Redirect::back();
        }

}

