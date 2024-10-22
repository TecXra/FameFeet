<?php

namespace Services;

use App\Helpers\PaginationHelper;
use App\Models\Celebrity;
use App\Models\User;
use App\Models\Shop;
use App\Models\BannedUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class ShopService
{
    public static function createShopItem($request)
    {
        $user = Auth::user();
        $celebrity_id = $user->celebrity->id;
        $shop = ShopService::saveShopItem($celebrity_id,$request);
        if($request->has('file_path')){
          $files = $request->file_path;
          MediaService::uploadImages($shop,$files);
        }
        return response()->json([
            'message' => 'Shop created successfully!'
        ]);
    }

    public static function saveShopItem($celebrity_id,$request){
        // $slug = createSlug($request,)
        $shop = New Shop();
        if($request->price == null || $request->price == 0){
          $shop->lock_media = false;
        }else{
          $shop->lock_media = true;
        }
        $shop->title = $request->title;
        // $shop->slug = $slug;
        $shop->price = $request->price;
        $shop->condition = $request->condition;
        $shop->quantity = $request->quantity;
        $shop->celebrity_id = $celebrity_id;
        $shop->description = $request->description;
        $shop->weight = $request->weight;
        $shop->ounce = $request->ounce;
        $shop->socks_size_id = $request->socks_size_id;
        $shop->save();

        $slug = createSlug($shop->title,$shop->id);
        $shop->slug = $slug;
        $shop->save();
        return $shop;
    }

   //edit Shop
   public static function editOnlyShop(Request $request,$id)
   {
        $user = Auth::user();
        $celebrity_id = $user->celebrity->id;
        $shop =  Shop::where('id','=',$id)
        ->where('celebrity_id','=',$celebrity_id)
        ->first();
        if(is_null($shop)){
            return response()->json([
                'message' => 'Not A shoped User'
            ]);
        }else{
                $shop->title = $request->title;
                $shop->price = $request->price;
                $shop->quantity = $request->quantity;
                $shop->description = $request->description;
                $shop->ounce = $request->ounce;
                $shop->celebrity_id = $celebrity_id;
                $shop->save();
                return response()->json([
                    'message' => 'Shop updated successfully!'
                ]);
           }
    }

    public static function getShopSingleItem($shopId)
    {
        $shopItem = Shop::query()
                ->with(['socksSize' => function ($query) {
                    $query->select('id', 'socks_size_name');
                }])
                ->with(['media' => function ($query) {
                    $query->select('id', 'file_path','mediaable_id');
                }])
                ->with(['celebrity'=> function($query){
                $query->select('id','user_id')
                ->with('user:id,username,avatar,state,zipcode');
                }])
                ->with('review')
                ->find($shopId);
            // return $shopItem;
        $avg = ShopService::avgRating($shopItem);

        if(count($shopItem->review) > 0){
            $data = ShopService::returnData($shopItem);
            $data['avrage_ratting'] = $avg;
            $data['review'] = $shopItem->review;
            return $data;
        }else{
            $data = ShopService::returnData($shopItem);
            return $data;
        }
    }

    public static function getShopsOfAuthCelebrity($celebrityId){
        $shops = Shop::query()
        ->with(['socksSize' => function ($query) {
          $query->select('id','socks_size_name');
         }])
        ->with(['media' => function ($query) {
               $query->select('id', 'file_path','mediaable_id');
           }])
        ->with(['celebrity'=> function($query){
           $query->select('id','gender','location','user_id')
           ->with('user:id,username,avatar');
        }])->where('celebrity_id',$celebrityId)->get();

      return $shops;
    }

    public static function getCelebrityShopItems($celebrityId)
    {
        $auth_user_id = Auth::user()->id;
        $celeb = Celebrity::find($celebrityId);
        $celebUser = User::withTrashed()->where('id',$celeb->user_id)->first();
        // $senderUserBlock = BannedUser::where('user_id', $celebUser->id)->first();
        $receiverUserBlock = BannedUser::where('banned_user_id',$celebUser->id)->first();
        $existingBlockFan = BannedUser::where('banned_user_id',$auth_user_id)->first();
        

        $del_user = User::where('account_status',4)->where('id',$celeb->user_id)->first();

        if(!$del_user){

            // if(!$senderUserBlock && !$receiverUserBlock ){
            if(!$existingBlockFan && !$receiverUserBlock ){
                $shopItems = Shop::query()

                ->with(['socksSize' => function ($query) {
                    $query->select('id','socks_size_name');
                }])
                ->with(['media' => function ($query) {
                    $query->select('id', 'file_path','mediaable_id');
                }])
                ->with(['celebrity'=> function($query){
                $query->select('id','gender','location','user_id')
                ->with('user:id,username,avatar');
                }])->whereHas('celebrity.user', function ($query){
                     $query->where('account_status',config('famefeet.account_status.active'));
                 })->where('celebrity_id',$celebrityId)
                ->get();
        return $shopItems;
    }else{
        return response()->json([
            'message' => 'we can not show shop items because you are blocked!'
        ]);
    }
    }else{
        return response()->json([
            'message' => 'Your account has been deleted. You cannot show content.'
        ]);
       }
    }





    public static function getAllShopItems($request,$auth_user_id)
    {

        $celebrityIds = [];
        if(isset($auth_user_id)){
            $user = getUserByUserId($auth_user_id);
            $blockedUserIds = BanUserService::getBlockUser($user);
            // return $blockedUserIds;
            $celebrityIds = Celebrity::whereIn('user_id',$blockedUserIds)->pluck('id');

        }

        $query = Shop::query();
        $query = $query->whereHas('celebrity.user', function ($query){
            $query->where('account_status',config('famefeet.account_status.active'));
        });
        if($request->filled('search')){
            $query->where('title', 'like', '%'.$request->search.'%')
            ->orWhereHas('celebrity.user', function ($query) use ($request) {
                $query->where('username', 'like', '%'.$request->search.'%');
            });
        }
        $query = $query->with(['socksSize' => function ($query) {
                        $query->select('id','socks_size_name');
                    }])
                ->with(['media' => function ($query) {
                        $query->select('id', 'file_path','mediaable_id');
                    }])
                ->with(['celebrity'=> function($query){
                    $query->select('id','gender','location','user_id')
                    ->with('user:id,username,avatar');
                }]);
        if(count($celebrityIds) > 0){
            $query = $query->whereNotIn('celebrity_id',$celebrityIds);
        }
        $query = $query->orderBy('created_at','DESC')->get();
        $result = PaginationHelper::paginate($query,$request->perPage);
        return $result;
     }

    public static function avgRating($shopItem){
        $rating = 0;
        $counter = 0;
        $avg = 0;
        if(count($shopItem->review) > 0){
            foreach ($shopItem->review as $singleReview) {
              $rating = $rating + $singleReview->rating;
              $counter = $counter + 1;
            }
           $avg = $rating / $counter;
        }
        return $avg;
      }

     public static function  returnData($shopItem)
      {
        $data = [
            "id" => $shopItem->id,
            'avrage_ratting' => 0,
            "title" => $shopItem->title,
            "price" => $shopItem->price,
            "condition" => $shopItem->condition,
            // "size" => $shopItem->size,
            "quantity" => $shopItem->quantity ,
            'weight' => $shopItem->weight,
            'ounce' => $shopItem->ounce,
            "description" => $shopItem->description,
            "lock_media" => $shopItem->lock_media,
            "celebrity_id" => $shopItem->celebrity_id,
            "created_at" => $shopItem->created_at,
            'socks_size' => $shopItem->socksSize,
            'media' => $shopItem->media,
            'celebrity' => $shopItem->celebrity,
            'review' => [],
        ];
        return $data;
    }

}
