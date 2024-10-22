<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Facades\Services\MiscService;

use Illuminate\Support\Facades\Auth;


class MiscController extends Controller
{
    public function getCelebrityMessagePrice(Request $request){
        $cuID = $request->cu_id;
        $fuID = null;
        if(Auth::guard('api')->user()){
            $authUser = Auth::guard('api')->user();
            if($authUser->user_type == config('famefeet.user_type.fan')){
                $fuID = $authUser->id;
            }
        }
        return MiscService::getCelebrityMessagePrice($cuID,$fuID);
    }

}
