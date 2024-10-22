<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Services\UserAddressService;

class UserAddressController extends Controller
{
    //
    public function saveUserAddress(Request $request){
        // return $request;
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|min:4',
            'country_code' => 'required',
            'mobile' => 'required',
            'address_line_one' => 'required',
            //'address_line_two' => 'required',
            'country' => 'required',
            'zipcode' => 'required',
            'state' => 'required',
            'city' => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        $result = UserAddressService::saveAddress($request);
        $userAllAddressList = UserAddressService::getAddress();
        
        if(count($userAllAddressList) == 1)
        {
            $address = UserAddress::find($userAllAddressList[0]->id);
            $address->update([
                'selected_address' => true,
            ]);
        }

        return $result;
    }

    public function getUserAddress(){
        $result = UserAddressService::getAddress();
        return $result;
    }

    public function editUserAddress(Request $request,$id){
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|min:4',
            'country_code' => 'required',
            'mobile' => 'required',
            'address_line_one' => 'required',
            // 'address_line_two' => 'required',
            'country' => 'required',
            'zipcode' => 'required',
            'state' => 'required',
            'city' => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        $result = UserAddressService::editAddress($request,$id);
        return $result;
    }

    public function setDefaultUserAddress($id){
        $allUserAddress = Auth::user()->userAddress;
        foreach ($allUserAddress as $userAddres) {
            $userAddres->update([
                'selected_address' => false,
            ]);
        }
        $address = UserAddress::find($id);
        $address->update([
              'selected_address' => true,
        ]);
        return response()->json([
            'message' => "Address set as default successfully!"
         ]);
    }

    public function deleteUserAddress($id)
    {
        $result = UserAddressService::deleteUserAddress($id);
        return $result;
    }

}
