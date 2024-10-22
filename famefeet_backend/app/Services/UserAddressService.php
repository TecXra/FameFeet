<?php

namespace Services;

use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;

class UserAddressService{

    public static function saveAddress($request){
        // return $request;

        $userAddress = new UserAddress();
        $userAddress->name = $request->name;
        $userAddress->country_code = $request->country_code;
        $userAddress->mobile = $request->mobile;
        $userAddress->address_line_one = $request->address_line_one;
        $userAddress->address_line_two = $request->address_line_two;
        $userAddress->country = $request->country;
        $userAddress->zipcode = $request->zipcode;
        $userAddress->state = $request->state;
        $userAddress->city = $request->city;
        //  $userAddress->selected_address = $request->selected_address;
        $userAddress->user_id = Auth::user()->id;
        $userAddress->save();

        return response()->json([
            'message' => "Address added successfully!"
        ]);
    }

    public static function editAddress($request,$id){
          $userAddress = UserAddress::find($id);
          $userAddress->name = $request->name;
          $userAddress->country_code = $request->country_code;
          $userAddress->mobile = $request->mobile;
          $userAddress->address_line_one = $request->address_line_one;
          $userAddress->address_line_two = $request->address_line_two;
          $userAddress->country = $request->country;
          $userAddress->zipcode = $request->zipcode;
          $userAddress->state = $request->state;
          $userAddress->city = $request->city;
        //   $userAddress->selected_address = $request->selected_address;
          $userAddress->user_id = Auth::user()->id;
          $userAddress->save();
          return response()->json([
            'message' => "Address updated successfully!"
        ]);

    }

    public static function getAddress(){
        $userAddress = Auth::user()->userAddress;
        return $userAddress;
    }

    public static function deleteUserAddress($id) {
      $userAddress = UserAddress::find($id);
      if(isset($userAddress))
      {
        $userAddress->delete();
        return response()->json([
          'message' => 'User address deleted successfully!'
        ],200);  
      }
      return response()->json([
        'message' => 'User address not found.'
      ],505);  
  }
}
