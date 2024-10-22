<?php

namespace App\Http\Controllers;

use Services\LikeService;

class LikesController extends Controller
{
    //
    public function likeOrUnlike($id)
    {
        $likes = LikeService::likesOfPost($id);
        return $likes;
    }
}
