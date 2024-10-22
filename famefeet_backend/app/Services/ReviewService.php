<?php
namespace Services;

use App\Models\Offer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderItem;
use App\Models\Review;
use App\Models\SubOrder;
use App\Models\User;
use App\Events\FanRateEvent;
use App\Models\Celebrity;
use Illuminate\Support\Facades\Auth;

class ReviewService{

    public static function sendReview($request){
     if($request->has('order_item_id')){
        try {
        //    return
            // return "yes";
            $orderItem = OrderItem::find($request->order_item_id);
            $subOrder =  SubOrder::find($orderItem->sub_order_id);
            // $shop = Shop::find($subOrder->celebrity_id);
            // return $subOrder;
            // return
            $sender = Auth::user();
            $celebUser = Celebrity::find($subOrder->celebrity_id);
            $receiver = User::find($celebUser->user_id);

            if($subOrder->status == 'complete'){
                if($orderItem->status == true){
                    $review = new Review();
                    $review->rating = $request->rating;
                    $review->comment = $request->comment;
                    $review->user_id = auth()->user()->id;
                    $review->review_type_id = $orderItem->shop_id;
                    $review->review_type = getReviewTypeName(config('famefeet.review_type.shop'));
                    $review->celebrity_id = $subOrder->celebrity_id;

                    // return $review;
                    $review->save();

                    $orderItem->status = false;
                    $orderItem->save();

                    $rate_type = 'order';
                    event(new FanRateEvent($review, $sender, $receiver, $rate_type));

                    return response()->json([
                        'message' => 'Your review sent successfully!'
                    ]);
                }else{
                    return response()->json([
                        'message' => 'You have already reviewed this product!'
                    ],401);
                }
            }else{
                return response()->json([
                    'message' => 'Check Order Status First!'
                ],401);
            }
        } catch (\Exception) {
            return response()->json([
                'message' => 'Somethig Wrong!!'
            ],505);
        }

       }elseif($request->has('offer_id')){
        try {
            $fanId = auth()->user()->fan->id;
            $offer = Offer::where('fan_id',$fanId)->find($request->offer_id);
            $sender = Auth::user();
            $celebUser = Celebrity::find($offer->celebrity_id);
            $receiver = User::withTrashed()->find($celebUser->user_id);
            if($receiver->account_status != config('famefeet.account_status.deleted')){
            if($offer->status == 'upload'){

                    $review = new Review();
                    $review->rating = $request->rating;
                    $review->comment = $request->comment;
                    $review->user_id = auth()->user()->id;
                    $review->celebrity_id = $offer->celebrity_id;
                    $review->review_type_id = $offer->id;
                    $review->review_type =  getReviewTypeName(config('famefeet.review_type.offer'));
                    $review->save();


                    $offer->status = 'review';
                    $offer->save();

                    $rate_type = 'offer';
                    event(new FanRateEvent($review, $sender, $receiver, $rate_type));

                    return response()->json([
                        'message' => 'Your Review sent successfully!'
                    ]);

            }else{
                return response()->json([
                    'message' => 'Check Offer Status First!'
                ],401);
            }
        }else{
            return response()->json([
                'message' => 'You can not review account has been deleted!'
            ],401);
        }

        } catch (\Exception) {
            return response()->json([
                'message' => 'Something Wrong!'
            ],505);
        }
       }else{
        return response()->json([
            'message' => 'Something Wrong!'
        ],505);
       }
    }


}
