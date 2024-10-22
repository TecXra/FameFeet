<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Shop;
use App\Models\SubOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Services\ShopService;

class ShopMediaController extends Controller
{

    public function __construct()
    {
        // $this->client = \Laravel\Passport\Client::where('password_client', 1)->first();
        $this->middleware('auth:api')->except(['getAllShopItems']);
        // $this->middleware('auth:api', ['only' => 'logoutUser']);
        // $this->middleware('auth:api')->except(['forgotPassword', 'loginUser']);
    }

    //show all shops
    public function index(Request $request){

        $search = $request['search'] ?? "";
        // if($search != ""){
        //     $shop = Shop::where('title', 'like', '%' . $search . '%')->paginate(10);
        // }else{
            $shop = Shop::orderBy('id','DESC')->paginate(15);
        // }

        return view("shop.index")->with('shops',$shop)->with('search',$search);
    }
   //edit single Shop
   public function edit($id){
    $shop = Shop::find($id);
    return view('shop.edit')->with('shop',$shop);
   }
   //update shop
   public function update(Request $request,$id){
    $request->validate([
        'title' => 'required|string|max:120',
        'price' => 'required|numeric|min:1',
        'description' => 'required|string'
    ]);
    $shop = Shop::find($id);
    $shop->update([
        'title' => $request['title'],
        'price' => $request['price'],
        'description' => $request['description'],
    ]);
    return redirect()->route('shop.all')
           ->with('success','Post Update Successfully!');
   }

   public function show($id){
    $shop = Shop::find($id);
    return view('shop.show')->with('shop',$shop);
   }


     // Create a Post with multiple files
    public function createShop(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'title' => 'required|string|min:4',
            'description' => 'required|string',
            'price' => 'required|between:0,99.99',
            'quantity' => 'required|integer',
            'file_path' => 'required',
            // 'weight' => 'required'

        ]);

        if($validation->fails()){
            return response()->json($validation->errors(), 400);
        }
        // call shop services
        $shop = ShopService::createShopItem($request);
        return $shop;

    }


   //-----------------------------
//    public function getAllShopItems(Request $request)
//    {
//         $user = Auth::user();
//         $blockedUserIds = BanUserService::getBlockUser($user);
//         $celebrityIds = Celebrity::whereIn('user_id',$blockedUserIds)->pluck('id');
//         return ShopService::getAllShopItems($request,$celebrityIds);
//     }
    //---------------------
    // public function getShopsOfCelebrity($id)
    // {
    //     return ShopService::getShopsOfCelebrity($id);
    // }


    //---------------------
    public function getCelebrityShopItems($celeb_id)
    {
        return ShopService::getCelebrityShopItems($celeb_id);
    }




    // ---------------------
    public function getShopsOfAuthCelebrity()
    {
        $celebrity_id = Auth::user()->celebrity->id;
        return ShopService::getShopsOfAuthCelebrity($celebrity_id);
    }
    //-----------------
    public function getShopSingleItem($id){
        return ShopService::getShopSingleItem($id);
    }

    //-------------------
    public function editShop(Request $request,$id)
        {
          $validation = Validator::make($request->all(),[
              'title' => 'required|string|min:4',
              'description' => 'required|string',
              'price' => 'required|numeric|min:1',
              'quantity' => 'required|integer|min:1',
              'ounce' => 'required'
              ]);
           if($validation->fails())
           {
              return response()->json($validation->errors(), 400);
           }
           $editShop = ShopService::editOnlyShop($request,$id);
           return $editShop;
        }

    //-----------------------
    public function deleteShop($id)
      {
        $user = Auth::user();
        $orderItems = OrderItem::where('shop_id', $id)->get();
        
        // Collect sub-order ids
        $subOrderIds = $orderItems->pluck('sub_order_id')->toArray();
        
        // Fetch sub-orders
        $subOrders = SubOrder::whereIn('order_id', $subOrderIds)->get();
        
        // Check if any sub-order has a "pending" status
        $hasPendingSubOrder = $subOrders->contains(function ($subOrder) {
            return $subOrder->status == 'pending';
        });
    
        if ($hasPendingSubOrder) {
            return response()->json([
                'message' => 'You cannot remove this item because it appears in pending orders.'
            ], 400);
        }
    
        // If no pending sub-orders, proceed with shop deletion
        $celebrity_id = $user->celebrity->id;
        $shop = Shop::where('id', $id)
            ->where('celebrity_id', $celebrity_id)
            ->first();
    
        if (!is_null($shop)) {
            // Delete associated media
            $shop->media()->delete();
    
            // Delete the shop
            $shop->delete();
    
            return response()->json([
                'message' => 'Shop item deleted successfully!'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Record Not Found!'
            ], 404);
        }
    //     //   return $id;
    //       $user = Auth::user();
    //       $orderItem = OrderItem::where('shop_id',$id)->get();
    //    //   new code
    //       $subOrderIds = [];
    //       foreach ($orderItem as $orderItems) {
    //         $subOrderIds[] = $orderItems['sub_order_id'];
    //         }
    //         $subOrders = SubOrder::whereIn('order_id', $subOrderIds)->get();
    //         foreach ($subOrders as $subOrder) {
    //             $subOrderStatus[] = $subOrder['status'];
    //             }
          
    //     //   end
    //       $celebrity_id = $user->celebrity->id;
        
    //       if(count($orderItem) == 0){
           
    //       $shop =  Shop::where('id',$id)
    //               ->where('celebrity_id',$celebrity_id)
    //               ->first();
    //       if(!is_null($shop)){
    //           $shop->delete();
    //           $shop->media()->delete();
    //           return response()->json([
    //               'message' => 'Shop item deleted successfully!'
    //           ],200);
    //       }else{
    //           return response()->json([
    //               'message' => 'Record Not Found!'
    //           ],404);
    //       }
    //     }else{
    //         return response()->json([
    //             'message' => 'you can not remove this item because this is appear in item orders'
    //         ],400);
    //     }

    }

    public function getAllShopItems(Request $request){
        $auth_user_id = null;
        if(Auth::guard('api')->user()){
            $auth_user_id = Auth::guard('api')->user()->id;
        }
        $shopItems = ShopService::getAllShopItems($request,$auth_user_id);
        return $shopItems;
    }

}
