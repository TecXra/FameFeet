<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Services\SharePostService;

class SharePostController extends Controller
{
    public function sharePost(Request $request){
        $validation = Validator::make($request->all(),[
            'user_id' => 'required',
            'post_id' => 'required'
        ]);



        if($validation->fails()){
           return response()->json($validation->errors(),400);
        }

        $result = SharePostService::PostShare($request);
        return $result;

    }

    public function getSharedPosts(){
        $result = SharePostService::getSharePostFanSide();
        return $result;
    }

    public function getAllPostsForSharing($id){
        // return $request;
        $result = SharePostService::getPostForSharing($id);
        return $result;
    }
}
