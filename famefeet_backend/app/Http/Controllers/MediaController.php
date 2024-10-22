<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Services\MediaService;

class MediaController extends Controller
{
    //
       //Edit Post Media
       public function editMedia(Request $request,$id)
       {
           $editMedia = MediaService::editPostWithMedia($request,$id);
           return $editMedia;
       }

        public function getAllContent(Request $request)
        {   //return $request;
            if($request->has('content_type') && $request->content_type == config('famefeet.content_type.images'))
            {
                $content = Post::with('media')
                           ->where('content_type',$request->content_type)
                           ->get();
                return $content;
            }
            if($request->has('content_type') && $request->content_type == config('famefeet.content_type.videos'))
            {
                $content = Post::with('media')
                          ->where('content_type',$request->content_type)
                          ->get();
                return $content;
            }
            if($request->has('title') && $request->title != '')
            {
               // return $request;
                $content = Post::with('media')
                           ->where('title','like','%'.$request->title .'%')->get();
            }
            $content = Post::with('media')->get();
            return $content;
        }

        public function checkVideoDuration(Request $request){
//           return $request['duration_payload'];
            // return $request;
            // return $request->duration_payload;
           return MediaService::checkVideoDuration($request->duration_payload, $request->extension);
        }
}
