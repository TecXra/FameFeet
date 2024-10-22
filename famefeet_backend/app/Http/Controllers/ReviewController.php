<?php

namespace App\Http\Controllers;


use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Services\ReviewService;

class ReviewController extends Controller
{
 public function createReview(Request $request){
       $result = ReviewService::sendReview($request);
       return $result;
 }


 public function getAuthCelebrityReviews(){
    $celebrity = Auth::user()->celebrity;
    // $reviesws =
    // return $celebrity_id;
    // $offer_ids = Offer::where('celebrity_id',$celebrity_id)->pluck('id');
    // $sub_order_ids = SubOrder::where('celebrity_id',$celebrity_id)->pluck('id');
    // return $order_detail_ids;
    $reviewsdata = Review::query()
        ->with(['user' => function ($query) {
            $query->withTrashed()->select('id', 'username','avatar','account_status');
        }])
        ->where('celebrity_id',$celebrity->id)
        ->orderBy('created_at','DESC')
        ->get();
    if(count($reviewsdata) > 0){
        return $this->reviewsJsonFormet($reviewsdata);
    }
    return $reviewsdata;
}


// public function getCelebrityReviewOnFanSide($celebrity_id){
//     // $offer_ids = Offer::where('celebrity_id',$celebrity_id)->pluck('id');
//     // $sub_order_ids = SubOrder::where('celebrity_id',$celebrity_id)->pluck('id');
//     $reviewsdata = Review::query()
//         ->with(['user' => function ($query) {
//             $query->select('id', 'username','avatar');
//         }])
//         ->where('celebrity_id',$celebrity_id)
//         ->get();

//     if(count($reviewsdata) > 0){
//         return $this->reviewsJsonFormet($reviewsdata);
//     }
//     return $reviewsdata;

// }


public function getCelebrityReviews($celeb_id){
    $reviewsdata = Review::query()
        ->with(['user' => function ($query) {
            $query->select('id', 'username','avatar');
        }])
        ->where('celebrity_id',$celeb_id)
        ->get();

    if(count($reviewsdata) > 0){
        return $this->reviewsJsonFormet($reviewsdata);
    }
    return $reviewsdata;

}



public function reviewsJsonFormet($reviews)
{
    foreach ($reviews as $review) {

        $rev = [
           'id' =>$review->id,
           'rating' => $review->rating,
           'comment' => $review->comment,
           'status'  => $review->status,
           'cereated_at' => $review->created_at,
           'user' => $review->user,
        ];

        $revi[] = $rev;
    }

    return $revi;
}

// public function getAuthUserReviews(){
//     $reviews = Review::query()->with(['subOrder'=> function($query){
//         $query->select('id','order_id','celebrity_id')
//             ->with(['celebrity' => function($query){
//                 $query->select('id','user_id')->with('user:id,username');
//             }]);
//         }])
//       ->with(['offer' => function ($query) {
//         $query->select('id', 'title','description','celebrity_id')->with(['celebrity' => function($query){
//             $query->select('id','user_id')->with('user:id,username');
//         }]);
//     }])
//     ->where('user_id',auth()->user()->id)
//     ->get();
//     // return $reviews;
//     if(count($reviews) > 0){
//         foreach ($reviews as $review) {
//             if(!is_null($review->subOrder)){
//                 // return "yes";
//                 $soldBy =  $review->subOrder->celebrity->user->username;
//                 $user_id =  $review->subOrder->celebrity->user->id;
//                 // $title = $review->orderDetail->shop->title;
//                 // $description = $review->orderDetail->shop->description;
//             }elseif(!is_null($review->offer_id)){
//                 $soldBy =  $review->offer->celebrity->user->username;
//                 $user_id =  $review->offer->celebrity->user->id;
//                 // $title =  $review->offer->title;
//                 // $description =  $review->offer->description;
//             }
//             $rev[] = [
//                 'id' => $review->id,
//                 'rating' => $review->rating,
//                 'comment' => $review->comment,
//                 'status'  => $review->status,
//                 // 'title'   => $title,
//                 // 'description' => $description,
//                 'user_id' => $user_id,
//                 'sold_by' => $soldBy,
//                 'created_at' => $review->created_at,
//              ];
//         }
//       return $rev;
//     }else{
//         return $reviews;
//     }
// }

public function getAuthUserShopItemReview(){
    // return 'yes';
    // $sub_order_ids = SubOrder::where('user_id',Auth::user()->id)->pluck('id');
    $reviews = Review::query()->with(['celebrity' => function($query){
                $query->select('id','user_id')->with('user:id,username');
            }])->with('shop')
        ->where('review_type',getReviewTypeName(config('famefeet.review_type.shop')))
        ->where('user_id',auth()->user()->id)
        ->get();

    // return $reviews;
    if(count($reviews) > 0){
        foreach ($reviews as $review) {

            $soldBy =  $review->celebrity->user->username;
            $user_id =  $review->celebrity->user->id;
            $celebrity_id  = $review->celebrity->id;
            $title = $review->shop->title;
            $description = $review->shop->description;

            $rev[] = [
                'id' => $review->id,
                'rating' => $review->rating,
                'comment' => $review->comment,
                'status'  => $review->status,
                'shop_item_title' => $title,
                'description' => $description,
                'user_id' => $user_id,
                'celebrity_id' => $celebrity_id,
                'sold_by' => $soldBy,
                'created_at' => $review->created_at,
             ];
        }
      return $rev;
    }else{
        return $reviews;
    }
}

public function getAuthUserOfferReview(){
    // $fan = Auth::user()->fan;
    // $offer_ids = Offer::where('fan_id',$fan->id)->pluck('id');
    // $reviews =  Review::query()->with(['offer' => function ($query) {
    //     $query->select('id', 'title','description','celebrity_id')->with(['celebrity' => function($query){
    //         $query->select('id','user_id')->with('user:id,username');
    //     }]);
    // }])
    // ->whereIn('offer_id',$offer_ids)
    // ->where('user_id',auth()->user()->id)
    // ->get();
    $reviews = Review::query()->with(['celebrity' => function($query){
        $query->select('id','user_id')
        // ->with('user:id,username');
        ->with(['user' => function($query){
            $query->withTrashed()->select('id','username','account_status');
        }]);
            }])
            ->with('offer')
        ->where('review_type',getReviewTypeName(config('famefeet.review_type.offer')))
        ->where('user_id',auth()->user()->id)
        ->get();
    // return $reviews;
    if(count($reviews) > 0){
        foreach ($reviews as $review) {
                $soldBy =  $review->celebrity->user->username;
                $account_status =  $review->celebrity->user->account_status;
                $user_id =  $review->celebrity->user->id;
                $celebrity_id = $review->celebrity->id;
                $title =  $review->offer->title;
                $description =  $review->offer->description;

            $rev[] = [
                'id' => $review->id,
                'rating' => $review->rating,
                'comment' => $review->comment,
                'status'  => $review->status,
                'title'   => $title,
                'description' => $description,
                'user_id' => $user_id,
                'celebrity_id' => $celebrity_id,
                'sold_by' => $soldBy,
                'account_status' => $account_status,
                'created_at' => $review->created_at,
             ];
        }
      return $rev;
    }else{
        return $reviews;
    }
}

}
